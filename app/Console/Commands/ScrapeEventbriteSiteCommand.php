<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Goutte\Client;
use App\Models\Category;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use DOMDocument;
use DOMXPath;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;



class ScrapeEventbriteSiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:eventSite-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap EventBrite Site Command And Storing Data To DB';

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
        $response = $client->request('GET', 'https://www.eventbrite.com');
        $html = $response->html();

        // Create a DOMDocument object and load the HTML content
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); // Disable libxml errors and warnings
        $dom->loadHTML($html);
        libxml_clear_errors(); // Clear libxml errors and warnings

        $browseSection = $dom->getElementById('browse-section');
        if ($browseSection) {
            $category_links = $browseSection->getElementsByTagName('a');
            foreach ($category_links as $link) {
                echo $link->textContent . '<br>';
            }
        }


        $pagesToScrape = 20; // Number of pages to scrape


        for ($page = 1; $page <= $pagesToScrape; $page++)
        {

            $url = "https://www.eventbrite.com/d/saudi-arabia/all-events/?page=$page";
            $response = $client->request('GET', $url);
            $html = $response->html();
            $crawler = new Crawler($html);


            $crawler->filter('ul li .discover-search-desktop-card .event-card  .event-card-details .Stack_root__1ksk7 ')
            ->each(function (Crawler $node) use (&$results) {
            $title = $node->filter('a h3')->text();
            $title_ar=GoogleTranslate::trans($title,'ar');
            $category = '';
            $category_ar = '';
            $nodes = $node->filter('[data-event-category]');

            if ($nodes->count() > 0) {
                $category = $nodes->attr('data-event-category');
                $category_ar = GoogleTranslate::trans($category,'ar');
            }
            else{
                $category = "conferences";
                $category_ar = GoogleTranslate::trans($category,'ar');

            }
            $regionAndCity = $node->filter('[data-event-location]')->attr('data-event-location');


            $client = new Client();

            $detailsUrl = $node->filter('a')->attr('href');
            $detailsResponse = $client->request('GET', $detailsUrl);
            $detailsHtml = $detailsResponse->html();

            // Create a new DOMDocument object for the details HTML
            $detailsDom = new DOMDocument();
            libxml_use_internal_errors(true);
            $detailsDom->loadHTML($detailsHtml);
            libxml_clear_errors();

            //scrape image src from details page
            $imageElements = $detailsDom->getElementsByTagName('img');
            $imageSrc="";


            if ($imageElements->length > 0) {
                $imageSrc = $imageElements->item(0)->getAttribute('src');
                
            }

            // Scrape the content of <p> tags details from the details page
            $paragraphs = $detailsDom->getElementsByTagName('p');
            $detailsContent = [];
            foreach ($paragraphs as $paragraph) {
                $detailsContent[] = $paragraph->textContent;

            }

            // Use DOMXPath to retrieve the element by class name
            $xpath = new DOMXPath($detailsDom);
            $className = 'conversion-bar__panel-info';
            $priceElements = $xpath->query("//*[contains(@class, '$className')]");
            $price = '';
            if ($priceElements->length > 0) {
                $price = $priceElements->item(0)->textContent;
            }

            $start_dateElement=$xpath->query("//div[contains(@class, 'event-details__main-inner')]//time[contains(@class, 'start-date')]");
            $st_element = '';
            if ($start_dateElement->length > 0) {
                $st_element = $start_dateElement->item(0)->getAttribute('datetime');
            }
            //  dd($st_element);

            $dateElement=$xpath->query("//div[contains(@class, 'date-info')]//span[contains(@class, 'date-info__full-datetime')]");
            $start_time = '';
            $end_time = '';
            $start_date = '';
            $end_date = '';
            if ($dateElement->length > 0) {
                $date = $dateElement->item(0)->textContent;
                $dateResults=  $this->extractDateTime($date,$st_element);
                $start_time = $dateResults['start_time'];
                $end_time = $dateResults['end_time'];

                $start_date = $dateResults['start_date'];
                $end_date = $dateResults['end_date'];

            }


            $locationElement=$xpath->query("//div[contains(@class, 'location-info__address')]");
            $location = '';
            $location_ar = '';
            if ($locationElement->length > 0) {
                $location = $locationElement->item(0)->textContent;
                $location_ar=GoogleTranslate::trans($location,'ar');

            }



            //scrape organized by from details page
            $organization = $xpath->query("//div[contains(@class, 'descriptive-organizer-info-mobile__name')]//a[contains(@class, 'descriptive-organizer-info-mobile__name-link')]");

            $organizationBy = '';

            if ($organization->length > 0) {
                $organizationBy = $organization->item(0)->textContent;
            }

            // Lookup or create the category
            $cat = Category::firstOrCreate(['name' => $category]);
            $cat->name_ar = $category_ar;
            $cat->save();

            // Split the $regionAndCity into city and region
            $parts = explode(',', $regionAndCity);
            $city = trim($parts[0]);
            $region = trim($parts[1]);

            $cityModel = City::where(function ($query) use ($city) {
                $query->where('name_ar',  $city )
                    ->orWhere('name_en', $city);
            })->first();

            $regionModel = Region::where(function ($query) use ($region) {
                $query->where('name_ar', $region)
                    ->orWhere('name_en', $region);
            })->first();

            $cityId = $cityModel ? $cityModel->id : null;
            $regionId = $regionModel ? $regionModel->id : null;

           
            $existingEvent = Event::where('event_name', $title)->first();


            if (!$existingEvent) {

                 $current_date = Carbon::parse($start_date);

                 // Create a new Event instance
                 $event = new Event();
                 $event->event_name = $title;
                 $event->event_name_ar = $title_ar;
                 $event->category_id = $cat->id;
                 $event->region_id = $regionId; // Set the region ID
                 $event->city_id = $cityId; // Set the city ID
                 if($imageSrc=="")
                 {
                    $event->event_image="https://th.bing.com/th/id/OIP.1CnzXBrrkXjKwwDzjxCXZAHaEY?rs=1&pid=ImgDetMain";

                 }
                 else{
                    $event->event_image = $imageSrc;

                 }
                 // Convert the array to a JSON string
                 $event->event_details = json_encode($detailsContent);
                 $event->organizedBy = $organizationBy;
                 $event->url = $detailsUrl;
                 $event->location = $location;
                 $event->location_ar = $location_ar;
                 $event->start_date = $start_date;
                 $event->end_date = $end_date;
                 $event->start_time =$start_time ;
                 // $event->end_time = $end_time ;
                 $event->end_time = $end_time;

                 $event->event_start_price = $price;
                 // Save the event to the database
                 $event->save();

                if($end_date !== null)
                {
                    $end_date=Carbon::parse($end_date);
                    $current_date = Carbon::parse($start_date->addDay());

                    while ($current_date < $end_date ) {

                            // Create a new Event instance
                            $event = new Event();
                            $event->event_name = $title;
                            $event->category_id = $cat->id;
                            $event->region_id = $regionId; // Set the region ID
                            $event->city_id = $cityId; // Set the city ID
                            $event->event_image = $imageSrc ?: "https://th.bing.com/th/id/OIP.1CnzXBrrkXjKwwDzjxCXZAHaEY?rs=1&pid=ImgDetMain";
                            // Convert the array to a JSON string
                            $event->event_details = json_encode($detailsContent);
                            $event->organizedBy = $organizationBy;
                            $event->url = $detailsUrl;
                            $event->location = $location;
                            $event->location_ar = $location_ar;
                            $event->start_date =$current_date;
                            $event->end_date = $end_date ;
                            $event->start_time =$start_time ;
                            $event->end_time = $end_time;

                            $event->event_start_price = $price;
                            // Save the event to the database
                            $event->save();
                       
                     $current_date->addDay();


                    }
                }




            }




        });



     }
        $this->info('Event inserted successfully.');




    }



    public function extractDateTime($dateString,$start_date_carbon)
    {

        // $dateString = "Thursday, April 25 · 9am - 7:30pm GMT+3";
        //$dateString = 'Tue, May 7, 1:00 PM'; // Or 'Tue, 1:00 PM'

        $pattern = '/([A-Za-z ]*\s?[A-Za-z*?]+(\s\d+)?)?\s?,?\s?([A-Za-z]+\s\d+)?(\s?·?\s?)?(\s?,?\s?)?(\d+(:\d+)?\s?[apm|APM]+)?\s?-?\s?([A-Za-z]+(\s\d+)?)?(\s?·?\s?)?(\d+(:\d+)?\s?[apm|APM]+)?/i';
        $matches = [];


        if(preg_match($pattern, $dateString, $matches)){
            $start_date="";
            $end_date="";
            $end_time="";
            $start_time="";



            // $dateString = "Thursday, April 25 · 9:30am -7:30pm GMT+3";
           if (count($matches) === 13) {
                // $start_date_carbon = $matches[3];
                $dayOfWeek = $matches[1];
                $start_time = date('H:i:s', strtotime($matches[6]));
                $end_time = date('H:i:s', strtotime($matches[11]));

                // Store the start date
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date =$start_date->addDay()->format('Y-m-d');
                // Return the start and end DateTime values
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];


            }
            // $dateString = "May 21 · 9am - May 22 · 5pm GMT+3";
            elseif(count($matches) === 12){
                // $start_date_carbon = $matches[1] ;
                $end_date_carbon = $matches[8] ;
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $endDate = Carbon::parse($end_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date = Carbon::createFromFormat('Y-m-d', $endDate);
                $start_time = date('H:i:s', strtotime($matches[6]));
                $end_time = date('H:i:s', strtotime($matches[11]));
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];


            }
            // $dateString = 'Tue, May 7, 1:00 PM';
            // $dateString = 'Tue,1:00 PM';

            elseif(is_array($matches) && count($matches) === 8){
                $day= $matches[1] ;
                // $start_date_carbon = $matches[2] ;
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date =$start_date->addDay()->format('Y-m-d');
                $start_time = date('H:i:s', strtotime($matches[6]));
                $end_time = date('H:i:s', strtotime($matches[7]));
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];

            }
            //$dateString = "Starts on Tuesday, May 7 · 1pm GMT+3";
            elseif(is_array($matches) && count($matches) === 9){

                $day= $matches[1] ;
                // $start_date_carbon = $matches[3] ;
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date =$start_date->addDay()->format('Y-m-d');
                $start_time = date('H:i:s', strtotime($matches[6]));
                $end_time = date('H:i:s', strtotime($matches[7]));
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];




            }
            elseif(is_array($matches) && count($matches) === 6){
                $day= $matches[1] ;
                // $start_date_carbon = $matches[3] ;
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date =$start_date->addDay()->format('Y-m-d');
                $start_time = date('H:i:s', strtotime($matches[5]));
                $end_time = date('H:i:s', strtotime($matches[5]));
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];

            }
            else{
                $time="9Am";
                $start_time = date('H:i:s', strtotime($time));
                $end_time = date('H:i:s', strtotime($time));

                // Store the start date
                $startDate = Carbon::parse($start_date_carbon)->toDateString();
                $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
                $end_date =$start_date->addDay()->format('Y-m-d');
                // Return the start and end DateTime values
                return [
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ];

            }





        }
        else{
            $time="9Am";
            $start_time = date('H:i:s', strtotime($time));
            $end_time = date('H:i:s', strtotime($time));

            // Store the start date
            $startDate = Carbon::parse($start_date_carbon)->toDateString();
            $start_date = Carbon::createFromFormat('Y-m-d', $startDate);
            $end_date =$start_date->addDay()->format('Y-m-d');
            // Return the start and end DateTime values
            return [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ];

        }







    }



}

