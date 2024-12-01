<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use App\Models\Category;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ScrapeVisitSaudiaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:visitSaudia-command';

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
        $client = new Client();
        $pagesToScrape = 10; // Number of pages to scrape
        for ($page = 1; $page <= $pagesToScrape; $page++)
        {

            $url = "https://book.visitsaudi.com/sa-en/all-cities/experiences?page=$page";
            $response = $client->request('GET', $url);
            $html = $response->html();
            $crawler = new Crawler($html);
            // Find all the <a> tags
                $crawler->filter('.grid a[hreflang="sa-en"]')
                ->each(function (Crawler $aTag) use (&$results) {

                // Get the href attribute
                $href = $aTag->attr('href');
                $url="https://book.visitsaudi.com$href";

                // Find the <div> element with the "card_card__lLzzb" class inside the <a> tag  for scrape image
                $cardDiv = $aTag->filter('.card_card__lLzzb');
                 // Find the second image element
                $imageNode = $cardDiv->filter('.card_img-container__MKFGc img')->eq(1);
                // Extract the image source URL
                $imageUrl = $imageNode->attr('src');
                dd($imageUrl);
                $image="https://book.visitsaudi.com$imageUrl";

                // Find the city element with the specified class
                $cityNode = $cardDiv->filter('.whitespace-nowrap');
                // Find the span element within the div
                $city_span = $cityNode->filter('span');
                // Extract the text content of the span
                $city = $city_span->text();


                $location = $city_span->text();
                $location_ar=GoogleTranslate::trans($location,'ar');

                $categoryNode = $cardDiv->filter('.line-clamp-1');
                // Find the second span element within the div
                $category_span = $categoryNode->filter('span')->eq(2);
                // Extract the text content of the span
                $category = $category_span->text();
                $category_ar="";
                if($category){
                $category_ar = GoogleTranslate::trans($category,'ar');


                }
                else{
                $category="experiences";
                $category_ar = GoogleTranslate::trans($category,'ar');


                }
                // Lookup or create the category
                $cat = Category::firstOrCreate(['name' => $category]);
                $cat->name_ar = $category_ar;
                $cat->save();


                $titleNode = $cardDiv->filter('.line-clamp-2');
                $title = $titleNode->text();
                $title_ar=GoogleTranslate::trans($title,'ar');


                // Find the inner div element containing the span
                $priceDivNode = $cardDiv->filter('.whitespace-nowrap')->eq(1);

                // Find the span element with the "font-semibold" class
                $priceNode = $priceDivNode->filter('span.font-semibold');
                if (!$priceNode->count()) {
                    // Handle the case where the element is not found
                    $price = null;
                } else {
                    $price = $priceNode->text();
                }

                //get details page
                $client = new Client();

                // Fetch the HTML content
                $details_page = $client->request('GET', $url);
                $html_details = $details_page->html();
                $crawler_details = new Crawler($html_details);

                // scrape organized_by
                $organized_by_div = $crawler_details->filter('div.text-sm.font-semibold');
                $aTag_detail = $organized_by_div->filter('a[hreflang="sa-en"]');
                $organized_by =$aTag_detail->text();


                // scrape details section
                $details_div = $crawler_details->filter('div.mb-5');
                $details =$details_div->text();

                $travel_time="AllYear";


                // Find the <div> element with the "flex flex-col gap-2 px-4" class to get duration
                $mainDiv = $crawler_details->filter('div.flex.flex-col.gap-2.px-4');
                $durationDiv = $mainDiv->filter('div.flex.items-center.justify-between')->eq(1);
                $durationSpan = $durationDiv->filter('span.font-bold')->first();
                $duration = $durationSpan->text();

                //scrape conditions

                $conditionDiv = $mainDiv->filter('div.flex.items-center.justify-between')->eq(2);
                $conditionSpan = $conditionDiv->filter('span.font-bold')->first();
                $condition = $conditionSpan->text();



                 // Get the current date
                 $currentDate = Carbon::now();

                 // Set the start date as the current date
                 $start_date = $currentDate->format('Y-m-d');
                 $end_date = $currentDate->endOfMonth()->format('Y-m-d');
                 $time="12Am";
                 $end_time = date('H:i:s', strtotime($time));
                 $start_time = date('H:i:s', strtotime($time));

                 $cityModel = City::where(function ($query) use ($city,$location_ar) {
                    $query->where('name_ar',  $location_ar )
                        ->orWhere('name_en', $city)
                        ->orWhere('name_en', 'LIKE', '%' . $city . '%');
                    })->first();

                $regionModel="";

                if($cityModel){
                $regionModel= $cityModel->region_id;
                }
                else{
                    $region = Region::where(function ($query) use ($city,$location_ar) {
                        $query->where('name_ar',  $location_ar )
                            ->orWhere('name_en', $city)
                            ->orWhere('name_ar', 'LIKE', '%' . $location_ar . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $city . '%');
                        })->first();
                    $regionModel=$region?$region->id:null;

                }

                $cityId = $cityModel ? $cityModel->id : null;
                $regionId = $regionModel ? $regionModel : null;

                $existingEvent = Event::where('event_name', $title)->first();
                if (!$existingEvent) {

                    // Create a new Event instance
                    $event = new Event();
                    $event->event_name = $title;
                    $event->event_name_ar = $title_ar;
                    $event->category_id = $cat->id;
                    $event->region_id = $regionId; // Set the region ID
                    $event->city_id = $cityId; // Set the city ID
                    if($image=="")
                    {
                       $event->event_image="https://scth.scene7.com/is/image/scth/new-banner-saudi-stop-over-visa:crop-375x280?defaultImage=new-banner-saudi-stop-over-visa";
   
                    }
                    else{
                       $event->event_image = $image;
   
                    }
                    $event->event_details = $details;
                    $event->organizedBy = $organized_by;
                    $event->url = $url;
                    $event->location = $location;
                    $event->location_ar = $location_ar;
                    $event->start_date = $start_date;
                    $event->end_date = $end_date;
                    $event->start_time =$start_time ;
                    $event->end_time = $end_time;
                    $event->conditions = $duration.'-'.$condition;
                    $event->duration = $travel_time;

                    $event->event_start_price = $price;
                    // Save the event to the database
                    $event->save();
   
                  
   
   
               }



        


    
               
            });
           
           
           


        }
        $this->info('Event inserted successfully.');

    
    }
}
