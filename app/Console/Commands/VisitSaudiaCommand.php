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

class VisitSaudiaCommand extends Command
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

        // The URL of the AJAX request
        $ajaxUrl = 'https://www.visitsaudi.com/bin/api/v1/events?locale=en&limit=0&offset=0';

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

        // $success = $data->success;
        $events = $data->data;
        foreach ($events as $event) {
            $webUrl = $event->eventLinkUrl;
            $title = $event->title;
            $cat = $event->category;
            $category="";
            foreach($cat as $c)
            {
                $category=$c;
            }
            // Lookup or create the category
            $cat = Category::firstOrCreate(['name' => $category]);

            $hero_image = $event->cardImage;
            $description = $event->shortDescription;
            $zone_late = $event->latitude;
            $zone_long = $event->longitude;
            $location=$event->city.$event->region;
            $city=$event->city;
            $region=$event->region;
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


            $start_time = $event->startTime;
            $end_time = $event->endTime;
            $start = $event->startDate;
            $end= $event->endDate;
            $start_date =  Carbon::parse($start)->format('Y-m-d');
            $end_date =  Carbon::parse($end)->format('Y-m-d');


            $event_type = $event->eventType;
            $new_note="";
            $note = $event->targetGroup;

            foreach($note as $n){
                $new_note = $n;
            }
            $hours = $event->periodDays;

            $existingEvent = Event::where('event_name', $title)
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
                    // Convert the array to a JSON string
                    $event->event_image = $hero_image;
                    $event->event_details = $description;
                    $event->url = $webUrl;
                    $event->start_date = $start_date;
                    $event->end_date = $end_date;
                    $event->start_time = $start_time;
                    $event->end_time = $end_time;
                    $event->conditions = $new_note;
                    $event->location = $location;
                    $event->zone_late = $zone_late;
                    $event->zone_long = $zone_long;
                    $event->event_type = $event_type;
                    $event->duration = $hours;
                    // Save the event to the database
                    $event->save();





               }

        }
        $this->info('Event inserted successfully.');

    }
}
