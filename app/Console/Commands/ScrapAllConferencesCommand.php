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

class ScrapAllConferencesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:allConferences-command';

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
        $response = $client->request('GET', 'https://allconferencealert.net/saudi-arabia.php');
        $html = $response->html();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $crawler = new Crawler($html);

        $row=0;
        $updatedValue="";
        $inputElement = $crawler->filter('input[type="hidden"]#row');
        if ($inputElement->count() > 0) {
            $inputElement->getNode(0)->setAttribute('value',$row);
            $updatedValue = $inputElement->attr('value');
        }
        $all="";
        $allElements = $crawler->filter('input[type="hidden"]#all');
        if ($allElements->count() > 0) {
            $all = $allElements->attr('value');
        }


        while($row<=$all)
        {

            $this->all_events($row);
            $row=$updatedValue+300;

        }




        $this->info('Event inserted successfully.');




    }



    public function all_events($row){

        // scrape All Categories from https://allconferencealert.net site
        $client = new Client();
        $response = $client->request('GET', 'https://allconferencealert.net/');
        $category_html = $response->html();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($category_html);
        libxml_clear_errors();

        $category_crawler = new Crawler($category_html);

        $categories_section= $category_crawler->filter('.categories-icon a h4');
        if ($categories_section) {
                foreach ($categories_section as $c) {
                $categories= $c->textContent . '<br>';
                    // Lookup or create the category
                    $category = Category::firstOrCreate(['name' => $categories]);

                }
            }



            // scrape events with post method with specified country and number of rows
                $client = new Client();
                $url = 'https://allconferencealert.net/countryAjaxHandler.php'; // Replace with the URL of the AJAX handler

            // Define the data parameters
                $data = [
                    'row' =>$row,
                    'search' => "saudi arabia",
                    ' filter'=>"",
                    'rowperpage'=>300
                ];

            // Make an HTTP POST request with the data parameters
                $crawler = $client->request('POST', $url, $data);

            // Extract and process the response
                $response = $client->getResponse()->getContent();

                $event_crawler = new Crawler();
                $event_crawler->addHtmlContent($response);
                $rows = $event_crawler->filter('tr.aevent');

                //Scrape date of event.
                $rows->each(function (Crawler $row) {
                $day = $row->filter('.date h3')->text();
                $month = $row->filter('.date span')->text();
                $all_date=$day . $month;
                // Parse the date string using Carbon
                $date = Carbon::createFromFormat('jS F', $all_date)->format('Y-m-d');

                //scrape title of event.
                $name = $row->filter('.name a')->text();

                //scrape location of event and region and city.
                $location=$row->filter('.venue')->text();
                // Split the $regionAndCity into city and region
                $parts = explode(',', $location);
                $city = $parts[0];
                $cityModel = City::where(function ($query) use ($city) {
                    $query->where('name_ar',  $city )
                        ->orWhere('name_en', $city)
                        ->orWhere('name_ar', 'LIKE', '%' . $city . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $city . '%');

                })->first();

                $regionModel="";
                if($cityModel){
                $regionModel= $cityModel->region_id;
                }
                $cityId = $cityModel ? $cityModel->id : null;
                $regionId = $regionModel ? $regionModel : null;

                //enter details page from the link.
                $client = new Client();
                $a=$row->filter('.name a')->first();
                $detailsUrl =  $row->filter('.name a')->attr('href');

                $detailsResponse = $client->request('GET','https://allconferencealert.net/'.$detailsUrl);
                $detailHtml = $detailsResponse->html();
                $dom = new DOMDocument();
                libxml_use_internal_errors(true);
                $dom->loadHTML($detailHtml);
                libxml_clear_errors();

                $detail_crawler = new Crawler($detailHtml);

                //scrape table that includes organizedBy,details,conditions,booking_url.
                $table = $detail_crawler->filter('table.table-bordered')->first();

                // Find the second <tr> element within the table
                $firstTr = $table->filter('tr')->eq(0);
                $details = $firstTr->filter('td p')->text();

                $thirdTr = $table->filter('tr')->eq(2);
                $organized_by = $thirdTr->filter('td')->eq(1)->text();

                $fourthTr = $table->filter('tr')->eq(4);
                $new_note1 = $fourthTr->filter('td')->eq(0)->text();
                $new_note2 = $fourthTr->filter('td')->eq(1)->text();
                $new_note = $new_note1.":".$new_note2;

                $sixTr = $table->filter('tr')->eq(5);
                $ev_url = $sixTr->filter('td a')->first();
                $event_url = $ev_url->attr('href');


                // Get all category names
                $categoryNames = Category::pluck('name')->toArray();

                // Initialize a variable to store the matching category
                $matchingCategory = null;

                // Iterate over the category names
                foreach ($categoryNames as $categoryName) {
                    if (stripos($name, $categoryName) !== false) {
                    // Category name found in the title
                        $matchingCategory = $categoryName;
                        break;
                    }
                }

                $category = null;
                $categoryId = null;
                if ($matchingCategory) {
                    // Category name found in the title
                    // Retrieve the category by name
                    $category = Category::where('name', $matchingCategory)->first();

                    if ($category) {
                        // Category found, get the category ID
                        $categoryId = $category->id;
                        $category = Category::where('name', 'conferences')->first();


                    }
                    else{
                        $category = Category::firstOrCreate(['name' => 'conferences']);
                        $categoryId = $category->id;

                    }
                }else{
                    $category = Category::firstOrCreate(['name' => 'conferences']);
                    $categoryId = $category->id;
                }

                $existingEvent = Event::where('event_name', $name)
                ->where('start_date', $date)
                ->where('city_id', $cityId)
                ->where('organizedBy', $organized_by)
                ->first();
                if (!$existingEvent) {

                    $s_time="9Am";
                    $e_time="11Pm";
                    $start_time = date('H:i:s', strtotime($s_time));
                    $end_time = date('H:i:s', strtotime($e_time));


                    // Create a new Event instance
                    $event = new Event();
                    $event->event_name = $name;
                    $event->category_id = $categoryId;
                    $event->region_id = $regionId; // Set the region ID
                    $event->city_id = $cityId; // Set the city ID
                    $event->event_details = $details;
                    $event->organizedBy = $organized_by;
                    $event->url = $event_url;
                    $event->event_image="https://allconferencealert.net/blog/wp-content/uploads/2023/08/Education-Conference-Pathway-To-Success.jpg";
                    $event->location = $location;
                    $event->start_date = $date;
                    $event->end_date = $date;
                    $event->start_time =$start_time ;
                    $event->end_time = $end_time;
                    $event->conditions = $new_note;
                    // Save the event to the database
                    $event->save();

                }

     });





     }
}
