<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\BrowserKit\HttpBrowser;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class HallaYallaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:hallaYallaSite-command';

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

        // $ajaxUrl = 'https://halayalla.com/_next/data/1e1d9fb4c177802e963669eb7af99bb93c6ce164/sa-ar/all-cities/experiences.json?lang=sa-en&location=all-cities&page=';
        $ajaxUrl ='https://halayalla.com/_next/data/243191c4cbf047dd415557398fc62e5405488ddb/sa-ar/all-cities/experiences.json?lang=sa-ar&location=all-cities&page=';
        $headers = [
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        // For GET requests
        $response = $client->request('GET', $ajaxUrl, [
            'headers' => $headers,
        ]);

        // The body of the response is typically JSON
        $content = $response->getBody()->getContents();
        $data = json_decode($content);

        $last_page=$data->pageProps->experiences->last_page;
        $events = $data->pageProps->experiences->data;
        // dd($events);


         for ($page = 1; $page <= $last_page; $page++)
         {

            // $pageUrl = "https://halayalla.com/_next/data/1e1d9fb4c177802e963669eb7af99bb93c6ce164/sa-ar/all-cities/experiences.json?lang=sa-en&location=all-cities&page=$page";
             $pageUrl = "https://halayalla.com/_next/data/243191c4cbf047dd415557398fc62e5405488ddb/sa-ar/all-cities/experiences.json?lang=sa-ar&location=all-cities&page=$page";

            $headers = [
                'X-Requested-With' => 'XMLHttpRequest',
            ];

            // For GET requests
            $response = $client->request('GET', $pageUrl, [
                'headers' => $headers,
            ]);

            // The body of the response is typically JSON
            $content = $response->getBody()->getContents();
            $data = json_decode($content);
            $events = $data->pageProps->experiences->data;
              foreach ($events as $event) {
                $slug=$event->slug;

                //get City slug
                $c_slug=$event->city;
                $city = "";
                if($c_slug){
                    $city = $c_slug->name;
                  }
                  else{
                    $city="";

                  }

                //get Region slug
                $r_slug=$event->region;
                $region = "";
                if($r_slug){
                    $region = $r_slug->name;
                  }
                  else{
                    $region="";

                  }



                 //get Category Slug
                 $cate = $event->category;
                 $category="";
                  if($cate){
                    $category=$cate->slug;

                  }
                  else{
                    $category="experiences";

                  }

                $webUrl = "https://halayalla.com/sa-ar/experiences/$city/$category/$slug";
                $title = $event->name;

                // Lookup or create the category
                $cat = Category::firstOrCreate(['name' => $category]);

                $hero_image = $event->venue_image;
                $location=$city.$region;

                $cityModel = City::where(function ($query) use ($city) {
                    $query->where('name_ar',  $city )
                        ->orWhere('name_en', $city)
                        ->orWhere('name_ar', 'LIKE', '%' . $city . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $city . '%');
                    })->first();

                $regionModel = Region::where(function ($query) use ($region) {
                    $query->where('name_ar', $region)
                        ->orWhere('name_en', $region)
                        ->orWhere('name_ar', 'LIKE', '%' . $region . '%')
                        ->orWhere('name_en', 'LIKE', '%' . $region . '%');
                        })->first();


                $cityId = $cityModel ? $cityModel->id : null;
                $regionId = $regionModel ? $regionModel->id : null;

                // Get the current date
                $currentDate = Carbon::now();

                // Set the start date as the current date
                $start_date = $currentDate->format('Y-m-d');

                // Loop until the end of the current month
                $end_date = $currentDate->endOfMonth()->format('Y-m-d');


                $time="12Am";
                $end_time = date('H:i:s', strtotime($time));
                $start_time = date('H:i:s', strtotime($time));
                $event_type = $event->type;

                $note = $event->venue_type .$event->venue_type_title;
                $new_note=$note;
                $price=$event->list_price;
                $duration="AllYear";

                $existingEvent = Event::where('event_name', $title)
                    ->where('start_date', $start_date)
                    ->where('end_date', $end_date)
                    ->where('region_id', $regionId)
                    ->where('city_id', $cityId)
                    ->first();

                if (!$existingEvent) {

                    $current_date = Carbon::parse($start_date);

                    // Create a new Event instance
                    $event = new Event();
                    $event->event_name = $title;
                    $event->category_id = $cat->id;
                    $event->region_id = $regionId;
                    $event->city_id = $cityId;
                    // Convert the array to a JSON string
                    $event->event_details = $title;
                    $event->event_image = $hero_image;
                    $event->url = $webUrl;
                    $event->start_date = $start_date;
                    $event->end_date = $end_date;
                    $event->start_time = $start_time;
                    $event->end_time = $end_time;
                    $event->conditions = $new_note;
                    $event->location = $location;
                    $event->event_type = $event_type;
                    $event->duration = $duration;
                    // Save the event to the database
                    $event->save();




               }

        }



        }
        $this->info('Event inserted successfully.');

    }
}
