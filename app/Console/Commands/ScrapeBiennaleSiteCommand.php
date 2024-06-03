<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use Goutte\Client;
use Normalizer;


use Symfony\Component\DomCrawler\Crawler;
use Carbon\Carbon;

class ScrapeBiennaleSiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:biennale-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
     public function handle()
     {
         // Create a new Goutte client
         $client = new Client();
         // Get the HTML content of the page
         $response = $client->request('GET', 'https://biennale.org.sa/ar/public-programs');

         // Find the hidden input element with the ID "program_count"
         $input = $response->filter('input#program_count')->first();

         $count_events = $input->attr('value');//47
         echo($count_events);
         $items_number=6;
         $iterations=floor($count_events/$items_number);


         $start = 0;

         for ($i = 0; $i < $iterations; $i++) {
         // while ($start<=$count_events) {
             // Construct the URL with the updated start value
             $url = "https://biennale.org.sa/ar/public-programs-list?start=$start&load_type=load_more&type=upcoming";
             $response = $client->request('GET', $url);
             $html = $response->html();
             $crawler = new Crawler($html);
             $programCards = $crawler->filter('.program-card');

             // Iterate over the program cards
             $programCards->each(function ($card) use($client){
                 // Extract data from each program card
                 $title = $card->filter('.card-content h5')->text();
                 // $date = $card->filter('.card-top-text .text-end')->text();
                 $image_Src = $card->filter('.card-image img')->attr('src');
                 $imageSrc =  urldecode($image_Src);
                 $category = $card->filter('.card-image .card-tag')->text();
                 $organized_by = $card->filter('.card-top-text span')->text();
                 $event_type=$card->filter('.clamp3')->text();
                 $a=$card->filter('a')->first();
                 $url=$card->filter('a')->attr('href');

                 $link=$a->link();
                 $details_page= $client->click($link);

                // Filter the elements with the class 'card-row' details arabic
                 $cardRows = $details_page->filter('.about-page-content .ticket-card .card-row');

                 $regionAndCity="";
                 $location="";
                 if ($cardRows->count() >= 9) {

                     $thirdCardRowRegion = $cardRows->eq(2);
                     // Extract the desired information from the third card-row element
                     $textContentRegion = $thirdCardRowRegion->filter('.content span b ')->text();
                     $location=$thirdCardRowRegion->filter('.content span a')->attr('href');
                     $regionAndCity= $textContentRegion ;
                 }

                 // $organized_by="";
                // $organized_by=$details_page->filter('.about-page-content h4 strong ')->text();




                 $contentDetails = $details_page->filter('p');
                 $all_details="";
                 if ($contentDetails->count() >= 5) {

                     // Select the third element using eq(2) since indices are zero-based
                     $details_content = $contentDetails->eq(2);
                     $details_contents = $details_content->filter('p')->text();

                     //get the details description of event
                     $details_content1 = $contentDetails->eq(3);
                     $details_contents1 = $details_content1->filter('p')->text();
                     $all_details= $details_contents  .$details_contents1;
                 }

                //get date and time and price from english detail page.
                 $english_page_details= $details_page->filter('header .onsite-lang-switcher a')->first();
                 $date_link_english=$english_page_details->link();
                 $english_details=$client->click($date_link_english);
                 $english_cardRows = $english_details->filter('.about-page-content .ticket-card .card-row');

                 $start_time = "";
                 $end_time = "";
                 $start_date = "";
                 $end_date = "";
                 $textContentCondition="";
                 // $textContentPrice="";
                 if ($english_cardRows->count() >= 9) {

                     $firstCardRowDate = $english_cardRows->eq(0);
                     // Extract the desired information from the first card-row element
                     $textContentDate = $firstCardRowDate->filter('.content span b ')->text();
                     $secondCardRowTime = $english_cardRows->eq(1);
                     // Extract the desired information from the second card-row element
                     $textContentTime = $secondCardRowTime->filter('.content span ')->text();

                     $date_time_Results = $this->extractDateAndTime($textContentDate, $textContentTime);
                     $start_time = $date_time_Results['start_time'];
                     $end_time = $date_time_Results['end_time'];
                     $start_date = $date_time_Results['start_date'];
                     $end_date = $date_time_Results['end_date'];

                     $fourthCardRowCondition = $english_cardRows->eq(3);
                     // Extract the desired information from the fourth card-row element
                     $textContentCondition = $fourthCardRowCondition->filter('.content span ')->text();

                     $fiveCardRowPrice = $english_cardRows->eq(4);
                     // Extract the desired information from the five card-row element
                     $textContentPrice = $fiveCardRowPrice->filter('.content span ')->text();

                 }


             // Lookup or create the category
            $normalizedCategory = Normalizer::normalize($category, Normalizer::FORM_C); // Normalize Arabic name

            // Check if a category with the normalized name exists
            $cat = Category::where('name', $normalizedCategory)->first();

            // If the category doesn't exist, create a new one
            if (!$cat) {
                $cat = Category::create(['name' => $normalizedCategory]);
            }

             // Split the $regionAndCity into city and region
             $parts = explode('،', $regionAndCity);
             $city = $parts[0];
             $region = $parts[1];


             $cityModel = City::where(function ($query) use ($city) {
                 $query->where('name_ar',  $city )
                     ->orWhere('name_en', $city);
             })->first();

             $regionModel = Region::where(function ($query) use ($region) {
                 $query->where('name_ar', $region)
                     ->orWhere('name_en', $region)
                     ->orWhere('name_ar', 'LIKE', '%' . $region . '%')
                     ->orWhere('name_en', 'LIKE', '%' . $region . '%');

                     })->first();


             $cityId = $cityModel ? $cityModel->id : null;
             $regionId = $regionModel ? $regionModel->id : null;


             $existingEvent = Event::where('event_name', $title)
                 ->where('region_id', $regionId)
                 ->where('city_id', $cityId)
                 ->where('start_date', $start_date)
                 ->where('end_date', $end_date)
                 ->first();

             if (!$existingEvent) {

                  $current_date = Carbon::parse($start_date);

                  // Create a new Event instance
                  $event = new Event();
                  $event->event_name = $title;
                  $event->category_id = $cat->id;
                  $event->region_id = $regionId; // Set the region ID
                  $event->city_id = $cityId; // Set the city ID
                  $event->event_image = $imageSrc;
                  $event->event_details = $all_details;
                  $event->organizedBy = $organized_by;
                  $event->url = $url;
                  $event->location = $location;
                  $event->start_date = $current_date;
                  $event->end_date = $end_date;
                  $event->start_time =$start_time ;
                  $event->end_time = $end_time;
                  $event->conditions = $textContentCondition;
                  $event->event_type = $event_type;

                  $event->event_start_price = $textContentPrice;
                  // Save the event to the database
                  $event->save();

                 if($end_date !== null)
                 {
                     $end_date=Carbon::parse($end_date);

                     while ($current_date <= $end_date ) {

                         $existing = Event::where('event_name', $title)
                         ->where('start_date', $current_date)
                         ->where('end_date', $end_date)
                         ->where('region_id', $regionId)
                         ->where('city_id', $cityId)
                         ->first();

                         if (!$existing) {

                             // Create a new Event instance
                             $event = new Event();
                             $event->event_name = $title;
                             $event->category_id = $cat->id;
                             $event->region_id = $regionId; // Set the region ID
                             $event->city_id = $cityId; // Set the city ID
                             $event->event_image = $imageSrc;
                             $event->event_details = $all_details;
                             $event->organizedBy = $organized_by;
                             $event->url = $url;
                             $event->location = $location;
                             $event->start_date = $current_date;
                             $event->end_date = $end_date;
                             $event->start_time =$start_time ;
                             $event->end_time = $end_time;
                             $event->conditions = $textContentCondition;
                             $event->event_type = $event_type;
                             $event->event_start_price = $textContentPrice;
                             // Save the event to the database
                             $event->save();
                         }
                      $current_date->addDay();


                     }
                 }




             }


          });


         // Increment the start value by 6
          $start += 6;
         }
         $this->info('Event inserted successfully.');

     }








     public function extractDateAndTime($date,$time){

         $start_date="";
         $end_date="";
         $end_time="";
         $start_time="";

         //"10 PM - 1 AM";
         // Extract start and end times
         if(preg_match('/(\d{1,2}(?::\d{2})?\s*[AP]M)\s*-?\s*(\d{1,2}(?::\d{2})?\s*[AP]M)?/', $time, $matches))
         {


           $start_time_string = trim($matches[1]);
             if(count($matches)===2)
             {
                 $time="12Am";
                 $end_time = date('H:i:s', strtotime($time));

             }
             else{
                 $end_time_string = trim($matches[2]);
                 $end_time_string = preg_replace('/(\d{1,2})(\s*[AP]M)/', '$1:00$2', $end_time_string);
                 $end_time = Carbon::createFromFormat('g:i A', $end_time_string);

             }

             // Append minutes if missing
             $start_time_string = preg_replace('/(\d{1,2})(\s*[AP]M)/', '$1:00$2', $start_time_string);
             $start_time = Carbon::createFromFormat('g:i A', $start_time_string);



         }
         //date =""Apr 22 2024 - Apr 24 2024"";

         if ($date === "") {
             // Get the current date
             $currentDate = Carbon::now();

             // Set the start date as the current date
             $start_date = $currentDate->format('Y-m-d');

             // Loop until the end of the current month
             $end_date = $currentDate->endOfMonth()->format('Y-m-d');
         } else {

             // Extract the start date and end date from the date range string
             $dateParts = explode(' - ', $date);
             if (count($dateParts) === 2) {
                 $startDateString = $dateParts[0];
                 $endDateString = $dateParts[1];

                 // Parse the start date and end date strings using Carbon
                 $start_date =  Carbon::createFromFormat('M d Y', $startDateString)->format('Y-m-d');
                 $end_date = Carbon::createFromFormat('M d Y', $endDateString)->format('Y-m-d');

             } else {
                 $startDateString = $dateParts[0];
                 // $start_date = Carbon::createFromFormat('M d Y', $date)->format('Y-m-d');
                 // Parse the start date and end date strings using Carbon

                 $start_date =  Carbon::createFromFormat('M d Y', $date);
                 // $start_date =  Carbon::parse($starting_date )->format('Y-m-d');
                 $end_date =  $start_date->addDay()->format('Y-m-d') ;
                 // $end_date = Carbon::createFromFormat('M d Y', $start_date)->addDay()->format('Y-m-d');
             }

         }






         // Return the start and end DateTime values
         return [
             'start_time' => $start_time,
             'end_time' => $end_time,
             'start_date' => $start_date,
             'end_date' => $end_date,
         ];



     }
}
