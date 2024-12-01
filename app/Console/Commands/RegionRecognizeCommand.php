<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use Goutte\Client;
use Normalizer;


// use Normalizer;


class RegionRecognizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recognize:region-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill null values of region_id in events table with specific value.';

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
        $cityNames = City::pluck('name_en')->toArray();
        $events = Event::whereNull('region_id')
            ->whereNull('city_id')
            ->orderBy('id')
            ->cursor();
        
        foreach ($events as $event) {

           // Initialize a variable to store the matching city
            $matchingCity = null; 
            $updated_name=str_replace("-", "", $event->event_name);
            $updated_location=str_replace("-", "", $event->location);

            foreach ($cityNames as $cityName) {

              $position = strpos($updated_name, $cityName)|| stripos($updated_location, $cityName);  
              if($position !== false) {

                 // City name found in the search query, and it's the last occurrence
                 $matchingCity = $cityName;
                 $lastMatchIndex = $position;
                  
                   
                }
            }
            
            $cityId = null;
            $regionId = null;
            if ($matchingCity) {

                // Retrieve the category by name
                $city= City::where('name_en', 'LIKE', '%' . $matchingCity . '%')->first();

                if ($city) {
                    // City found, get the city ID
                    $cityId = $city->id;
                    $regionId = $city->region_id;
                    $event->city_id= $cityId;
                    $event->region_id= $regionId;
                    $event->save();

                }
                    
            }

          

        }



        #################################################3


        $cityArabicNames = City::pluck('name_ar')->toArray();
        $events_arabic = Event::whereNull('region_id')
            ->whereNull('city_id')
            ->orderBy('id')
            ->cursor();
        
        foreach ($events_arabic as $event_ar) {

            // Initialize a variable to store the matching city
            $matchingCity = null; 
            $updated_name=str_replace("-", "", $event_ar->event_name_ar);
            $updated_location=str_replace("-", "", $event_ar->location_ar);


            foreach ($cityArabicNames as $cityArabicName) {

              $position = strpos($updated_name, $cityArabicName) || stripos($updated_location, $cityArabicName); 

              if($position !== false) {

                // City name found in the search query, and it's the last occurrence
                $matchingCity = $cityArabicName;
                $lastMatchIndex = $position;
                  
                   
              }
            }
            
            $cityId = null;
            $regionId = null;
            if ($matchingCity) {

                $city= City::where('name_ar', 'LIKE', '%' . $matchingCity . '%')->first();

                if ($city) {
                    // City found, get the city ID and region ID
                    $cityId = $city->id;
                    $regionId = $city->region_id;
                    $event->city_id= $cityId;
                    $event->region_id= $regionId;
                    $event->save();

                }
                    
            }

          

        }

        #################################################################     

        $region_events = Event::whereNull('region_id')->orderBy('id')->get();
        $regionNames = Region::pluck('name_en')->toArray();
    
        foreach ($region_events as $region_event) {
            $cityId = $region_event->city_id;
            $city = City::where('id', $cityId)->first();

            if ($city) {
                $regionId = $city->region_id;
                $region_event->region_id = $regionId;
                $region_event->save();
            } else {
                $matchingRegion = null;
                $updated_name = str_replace("-", " ", $region_event->event_name);
                $updated_location = str_replace("-", " ", $region_event->location);
        
                foreach ($regionNames as $regionName) {
                    $position = stripos($updated_name, $regionName) || stripos($updated_location, $regionName);
                    if ($position !== false) {
                        $matchingRegion = $regionName;
                    }
                }
        
                if ($matchingRegion) {
                    $region = Region::where('name_en', 'LIKE', '%' . $matchingRegion . '%')->first();

                    if ($region) {
                        $regionId = $region->id;
                        $region_event->region_id = $regionId;
                        $region_event->save();
                    }
                }
            }
        }
        


        ###########################################################

        $cityNamesArabic = City::pluck('name_ar')->toArray();

        foreach ($cityNamesArabic as $cityNameArabic) {
       
           $cities_events = Event::where('event_name_ar', 'like', '%' . $cityNameArabic . '%')
            ->whereNull('region_id')
            ->orderBy('id')
            ->get(); 

            $regionId="";

            foreach ($cities_events as $city_event) {
                $cityId = $city_event->city_id;
                $city= City::where('id',$cityId )->first();

                if($city){
                    $regionId = $city->region_id;
                    $city_event->region_id = $regionId;
                    $city_event->save();
                }
            } 

        }

 
        #############################################################


        $lat_long_events = Event::whereNotNull('zone_late')
                ->whereNotNull('zone_long')
                ->get();
         echo($lat_long_events->count());
                
        foreach ($lat_long_events as $lat_long_event) {
            $lat=str_replace(",","", $lat_long_event->zone_late);
            $long=str_replace(",","", $lat_long_event->zone_long);

            $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=$lat&lon=$long";

            $client = new Client();

            $crawler = $client->request('GET', $url);
            $response = $client->getResponse();

            if ($response->getStatusCode() == 200) {

                $data = json_decode($response->getContent(), true);
                $options = array(
                    'http' => array(
                    'header' => "User-Agent: Your-App-Name (contact@your-email.com)\r\n"
                    )
                );

                $context = stream_context_create($options);
                $response = file_get_contents($url, false, $context);
                $data = json_decode($response, true);
                $region = $data['address']['state'] ?? '' ;
                // Lookup or create the region
                $normalizedRegion= Normalizer::normalize($region, Normalizer::FORM_C); // Normalize Arabic name
                $regionNames = Region::pluck('name_ar')->toArray();
                $regionRecognize= Region::where('name_ar', 'LIKE', '%' . $normalizedRegion . '%')->first();
                    
                if ($regionRecognize) {
                    $regionId = $regionRecognize->id;
                    $lat_long_event->region_id= $regionId;
                    $lat_long_event->save();
                    }


                $city=$data['address']['province']?? '';
                
                // Lookup or create the region
                $normalizedCity= Normalizer::normalize($city, Normalizer::FORM_C); // Normalize Arabic name
                $cityRecognize= City::where('name_ar', 'LIKE', '%' . $normalizedCity . '%')->first();
                if ($cityRecognize) {
                    // City found, get the city ID
                    $cityId = $cityRecognize->id;
                    $lat_long_event->city_id= $cityId;
                    $lat_long_event->save();

                }
                
        
            }

            else {
                $data = null;
            }
        }




       
    


    


    }
}
