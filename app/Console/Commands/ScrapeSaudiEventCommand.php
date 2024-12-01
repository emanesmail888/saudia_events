<?php

namespace App\Console\Commands;
use App\Models\Event;
use App\Models\Category;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;


use Illuminate\Console\Command;

class ScrapeSaudiEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:saudEvent-command';

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
        // For GET requests
        for ($i=0; $i <=3 ; $i++) { 
            // The URL of the category request
            $CategoryUrl = 'https://cpass.saudievents.sa/api/interests?lang=en';

            $headers = [
                'X-Requested-With' => 'XMLHttpRequest',
            ];

       
        
            $category_response = $client->request('GET', $CategoryUrl, [
                'headers' => $headers,
            ]);
            // The body of the response is typically JSON
            $category_content = $category_response->getBody()->getContents();
            $category_data = json_decode($category_content);

            $categories = $category_data->data;
            // Lookup or create the category
            foreach ($categories as $category) {
            $category = Category::firstOrCreate(['name' => $category->name]);
            $category_ar = GoogleTranslate::trans($category->name,'ar');

            $category->name_ar = $category_ar;
            $category->save();
            }
        }

        // The URL of the AJAX request
        $ajaxUrl = 'https://cpass.saudievents.sa/api/getevents?lang=en&interests%5B%5D=&zone_id=&season_id=&title=&date=';

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

        $success = $data->success;
        $events = $data->data;

        foreach ($events as $event) {
            $w_Url = $event->ticket_mix_url;
            $webUrl="";

            if($webUrl == '#' ||$webUrl=="")
            {
                $webUrl="https://saudievents.sa/events-en.html";
            }
            else{
                $webUrl = $event->ticket_mix_url;

            }
            $title = $event->title;
            $title_ar=GoogleTranslate::trans($title,'ar');

            $category = $event->category;
            $price = $event->price_from;
            $zone = $event->zone;
            $zone_ar = GoogleTranslate::trans($zone,'ar');

            $hero_image = $event->hero_image;
            $description = $event->description;
            $interests = $event->interests;
            $zone_late = $event->zone_lat;
            $zone_long = $event->zone_long;
            $event_time = $event->event_time;
            $event_all_date = $event->event_date;
            $event_date = "";

            if ($event_all_date === "-") {
                $event_date = "";

            }
            else{
                $event_date = $event_all_date;

            }
            $date_time_Results = $this->extractDateAndTime($event_date, $event_time);
            $start_time = $date_time_Results['start_time'];
            $end_time = $date_time_Results['end_time'];
            $start_date = $date_time_Results['start_date'];
            $end_date = $date_time_Results['end_date'];

            $event_type = $event->event_type;
            $new_note = $event->new_note;
            $hours = $event->hours;

            $existingEvent = Event::where('event_name', $title)->first();

            if (!$existingEvent) {
                $current_date = Carbon::parse($start_date);

                foreach ($category as $c) {
                    $cat = Category::findOrFail($c);
                    $category_id = $cat->id;

                    $event = new Event();
                    $event->event_name = $title;
                    $event->event_name_ar = $title_ar;

                    $event->category_id = $category_id;
                    $event->event_image = $hero_image;
                    $event->event_details = json_encode($description);
                    $event->url = $webUrl;
                    $event->location = $zone;
                    $event->location_ar = $zone_ar;
                    $event->start_date = $start_date;
                    $event->end_date = $end_date;
                    $event->start_time = $start_time;
                    $event->end_time = $end_time;
                    $event->conditions = $new_note;
                    $event->zone_late = $zone_late;
                    $event->zone_long = $zone_long;
                    $event->event_type = $event_type;
                    // $event->duration = $duration?:$hours;
                    $event->duration = $hours;
                    $event->event_start_price = $price;
                    $event->save();
                }
                if($end_date !== null)
                {   
                    $end_date=Carbon::parse($end_date);
                    
                    $current_date = Carbon::parse($start_date)->addWeek();


                    while ($current_date <= $end_date ) {

                        $existing = Event::where('event_name', $title)->first();
                        // if (!$existing) {
                            foreach ($category as $c) {
                                $cat = Category::findOrFail($c);
                                $category_id = $cat->id;

                                $event = new Event();
                                $event->event_name = $title;
                                $event->event_name_ar = $title_ar;
                                $event->category_id = $category_id;
                                $event->event_image = $hero_image;
                                $event->event_details = json_encode($description);
                                $event->url = $webUrl;
                                $event->location = $zone;
                                $event->location_ar = $zone_ar;
                                $event->start_date = $current_date;
                                $event->end_date = $end_date;
                                $event->start_time = $start_time;
                                $event->end_time = $end_time;
                                $event->conditions = $new_note;
                                $event->zone_late = $zone_late;
                                $event->zone_long = $zone_long;
                                $event->event_type = $event_type;
                                $event->duration = $hours;
                                $event->event_start_price = $price;
                                $event->save();
                            }
                        //}

                     $current_date->addWeek();


                    }
                }
            }
        }

        $this->info('Event inserted successfully.');

    }








    public function extractDateAndTime($date,$time){

        $start_date="";
        $end_date="";
        $end_time="";
        $start_time="";
        $duration="";

        //"<p>10 PM - 1 AM</p>";
        // Extract start and end times
        if(preg_match('/(\d{1,2}(?::\d{2})?\s*[AP]M)\s*-?\s*(\d{1,2}(?::\d{2})?\s*[AP]M)?/', $time, $matches) || preg_match('/(\d{1,2}(?::\d{2})?\s*[AP]M)\s*0\s*(\d{1,2}(?::\d{2})?\s*[AP]M)/', $time, $matches))
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
        //date ="15 Apr - 18 Apr";
        //date = "From 1 Dec";
        //date = "1 Dec";

        // Extract start and end dates
        $dates = explode(" - ", $date);

        if ((isset($dates[1]) )) {
            // Extract the start and end dates from the given date range
            $start_date = Carbon::createFromFormat('d M', $dates[0])->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d M', $dates[1])->format('Y-m-d');

        }

        elseif(preg_match('/From (\d+ [A-Za-z]+)/', $date, $matches)||preg_match('/(\d+ [A-Za-z]+)/', $date, $matches))
        {
            $start_date = Carbon::createFromFormat('d M', $matches[1])->format('Y-m-d');
            $end_date = Carbon::createFromFormat('Y-m-d', $start_date)->addDay()->format('Y-m-d');


        }elseif($date== "All year long")
        {
             // Get the current date
             $currentDate = Carbon::now();

             // Set the start date as the current date
             $start_date = $currentDate->format('Y-m-d');

             // Loop until the end of the current month
             $end_date = $currentDate->addDay()->format('Y-m-d');
            //  $duration="AllYear";


        }else
        {


            if ($date === "") {
                // Get the current date
                $currentDate = Carbon::now();

                // Set the start date as the current date
                $start_date = $currentDate->format('Y-m-d');

                // Loop until the end of the current month
                $end_date = $currentDate->addWeek()->format('Y-m-d');
                // $duration="AllYear";


            }
            //  else {
            //     // Extract start and end dates
            //     $dates = explode(" - ", $date);
            //     // Extract the start and end dates from the given date range
            //     $start_date = Carbon::createFromFormat('d M', $dates[0])->format('Y-m-d');
            //     $end_date = Carbon::createFromFormat('d M', $dates[1])->format('Y-m-d');
            //     $duration="AllYear";

            // }




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


