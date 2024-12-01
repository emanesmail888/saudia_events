<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use Carbon\Carbon;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\HttpClient\HttpClient;

class ScrapeWebookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:webook-command';

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
        $accessToken = "_nOOOX6K1meTmE-2rrZivhrgCZPL8aJDOlaMa8n-K1g"; 
        $this->fetch_experiences($accessToken);
        $this->fetch_events($accessToken);
    
    }


    function fetch_experiences($accessToken) {
        $url = "https://graphql.contentful.com/content/v1/spaces/vy53kjqs34an/environments/master";
    
        // Define your GraphQL query
       
        $query = <<<GRAPHQL
        query getExperiences(\$lang: String, \$limit: Int, \$skip: Int, \$where: ExperienceFilter, \$order: [ExperienceOrder]) {
            experienceCollection(locale: \$lang, limit: \$limit, skip: \$skip, where: \$where, order: \$order) {
                total
                items {
                    id
                    title
                    subtitle
                    description
                    slug
                    startingPrice
                    discountedPrice
                    currencyCode
                    image11 {
                        url
                        title
                    }
                    location {
                        title
                        address
                        city
                        countryCode
                        location {
                        lat
                        lon
                              }
                    }
                    schedule{
                        closeDateTime
                        openDateTime
                    } 
                    category{
                        title
                       
                    }
                    eventType
                    startingPrice 
                    ticketingUrlSlug   
                }
            }
        }
             
        GRAPHQL;
    
        // Define the variables
        $variables = [
            "lang" => "en-US",
            "limit" => 90,
            "skip" => 0,
            "where" => ["visibility_not" => "private"],
            "order" => ["order_ASC", "sys_publishedAt_DESC"]
        ];
    
        // Set up headers
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];
    
        // Prepare the request payload
        $payload = json_encode([
            'query' => $query,
            'variables' => $variables
        ]);
    
        // Create an HttpClient instance
        $client = HttpClient::create();
    
        // Perform the POST request
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'body' => $payload,
        ]);
    
        // Check the response status code
        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            // Process the response
            $data = $response->toArray(); // Automatically decode JSON response
            // Check if 'experienceCollection' exists in the data array
            
            if (isset($data['data']['experienceCollection']) && isset($data['data']['experienceCollection']['items'])) {
                foreach ($data['data']['experienceCollection']['items'] as $item) {
                    $title = $item['title'] ?? 'N/A';
                    $event_type = $item['eventType'] ?? 'N/A';
                    $title_ar=GoogleTranslate::trans($title,'ar');

                    $city = $item['location']['city'] ?? 'N/A';
                    $image_url = $item['image11']['url'] ?? 'N/A';
                    $openDateTime = $item['schedule']['openDateTime'] ?? Carbon::now(); // Extract closeDateTime

                    $closeDateTime = $item['schedule']['closeDateTime'] ?? $openDateTime ; // Extract closeDateTime
                    $category=$item['category']['title'] ?? 'experiences';
                    $category_ar = GoogleTranslate::trans($category,'ar');

                    $location=$item['location']['title'] ?? 'N/A';
                    $location_ar = GoogleTranslate::trans($location,'ar');

                    $price=$item['startingPrice'] ?? 'N/A';



                    
                    // Lookup or create the category
                    $cat = Category::firstOrCreate(['name' => $category]);
                    $cat->name_ar = $category_ar;
                    $cat->save();

                    $lat=$item['location']['location']['lat'] ?? 'N/A';
                    $lon=$item['location']['location']['lon'] ?? 'N/A';
                    $url="https://webook.com/en/experiences/".$item['ticketingUrlSlug'] ?? 'N/A';
                    // Use Carbon to parse the date-time strings
                    $openDate = Carbon::parse($openDateTime);
                    $closeDate = Carbon::parse($closeDateTime);

                    $cityModel = City::where(function ($query) use ($city) {
                        $query->where('name_ar',  $city )
                            ->orWhere('name_en', $city)
                            ->orWhere('name_ar', 'LIKE', '%' . $city . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $city . '%');
                        })->first();

                    $cityId = $cityModel ? $cityModel->id : null;
                    $regionId=$cityModel ? $cityModel->region_id : null;
                    $existingEvent = Event::where('event_name', $title)
                    ->where('city_id', $cityId)
                    ->first();

                    if (!$existingEvent) {

                        // Create a new Event instance
                        $event = new Event();
                        $event->event_name = $title;
                        $event->event_name_ar = $title_ar;

                        $event->category_id = $cat->id;
                        $event->region_id = $regionId;
                        $event->city_id = $cityId;
                        // Convert the array to a JSON string
                        $event->event_details = $title;
                        $event->event_image = $image_url;
                        $event->url = $url;
                        $event->start_date = $openDate->format('Y-m-d');
                        $event->end_date = $closeDate->format('Y-m-d');
                        $event->start_time = $openDate->format('H:i:s');
                        $event->end_time =  $closeDate->format('H:i:s');
                        $event->location = $location;
                        $event->location_ar = $location_ar;
                        $event->event_type = $event_type;
                        $event->zone_late = $lat;
                        $event->zone_long = $lon;
                        $event->event_start_price = $price;
                        // Save the event to the database
                        $event->save();




                    }



                }
                echo "Events stored successfully.";

            } else {
                echo "No events found or eventCollection is missing.\n";
            }

        } else {
            echo "Error: " . $statusCode . " - " . $response->getContent(false);
        }
    }


    
    function fetch_events($accessToken) {
        $url = "https://graphql.contentful.com/content/v1/spaces/vy53kjqs34an/environments/master";
    
        // Define your GraphQL query
        $query = <<<GRAPHQL
        query getEventListing(\$lang: String, \$limit: Int, \$skip: Int, \$where: EventFilter, \$order: [EventOrder]) {
            eventCollection(locale: \$lang, limit: \$limit, skip: \$skip, where: \$where, order: \$order) {
                total
                items {
                    id
                    title
                    subtitle
                    description {
                        json
                    }
                    slug
                    startingPrice
                    currencyCode
                    image11 {
                        url
                        title
                    }
                    location {
                        title
                        address
                        city
                        countryCode
                        location {
                        lat
                        lon
                              }
                    }
                    schedule{
                        closeDateTime
                        openDateTime
                    } 
                    category{
                        title
                       
                    }
                    eventType
                    startingPrice 
                    ticketingUrlSlug   
                }
            }
        }
        GRAPHQL;
    
        // Define the variables
        $variables = [
            "lang" => "en-US",
            "limit" => 50,
            "skip" => 0,
            "where" => [
                "visibility_not" => "private",
                "location" => ["countryCode" => "SA"] // Adjust this based on your needs
            ],
            "order" => ["order_ASC", "sys_publishedAt_DESC"]
        ];
    
        // Set up headers
        $headers = [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ];
    
        // Prepare the request payload
        $payload = json_encode([
            'query' => $query,
            'variables' => $variables
        ]);
    
        // Create an HttpClient instance
        $client = HttpClient::create();
    
        // Perform the POST request
        $response = $client->request('POST', $url, [
            'headers' => $headers,
            'body' => $payload,
        ]);
    
        // Check the response status code
        $statusCode = $response->getStatusCode();
        if ($statusCode === 200) {
            // Process the response
            $data = $response->toArray(); // Automatically decode JSON response
            // print_r($data);  // Print or process your data
            // Check if 'eventCollection' exists in the data array
            
            if (isset($data['data']['eventCollection']) && isset($data['data']['eventCollection']['items'])) {
                foreach ($data['data']['eventCollection']['items'] as $item) {
                    $title = $item['title'] ?? 'N/A';
                    $event_type = $item['eventType'] ?? 'N/A';
                    $title_ar=GoogleTranslate::trans($title,'ar');

                    $city = $item['location']['city'] ?? 'N/A';
                    $image_url = $item['image11']['url'] ?? 'N/A';
                    $openDateTime = $item['schedule']['openDateTime'] ?? Carbon::now(); // Extract closeDateTime

                    $closeDateTime = $item['schedule']['closeDateTime'] ?? $openDateTime ; // Extract closeDateTime
                    $category=$item['category']['title'] ?? 'N/A';
                    $category_ar = GoogleTranslate::trans($category,'ar');

                    $location=$item['location']['title'] ?? 'N/A';
                    $location_ar = GoogleTranslate::trans($location,'ar');

                    $price=$item['startingPrice'] ?? 'N/A';



                    
                    // Lookup or create the category
                    $cat = Category::firstOrCreate(['name' => $category]);
                    $cat->name_ar = $category_ar;
                    $cat->save();

                    $lat=$item['location']['location']['lat'] ?? 'N/A';
                    $lon=$item['location']['location']['lon'] ?? 'N/A';
                    $url="https://webook.com/en/events/".$item['ticketingUrlSlug'] ?? 'N/A';
                    // Use Carbon to parse the date-time strings
                    $openDate = Carbon::parse($openDateTime);
                    $closeDate = Carbon::parse($closeDateTime);

                    $cityModel = City::where(function ($query) use ($city) {
                        $query->where('name_ar',  $city )
                            ->orWhere('name_en', $city)
                            ->orWhere('name_ar', 'LIKE', '%' . $city . '%')
                            ->orWhere('name_en', 'LIKE', '%' . $city . '%');
                        })->first();

                    $cityId = $cityModel ? $cityModel->id : null;
                    $regionId=$cityModel ? $cityModel->region_id : null;
                    $existingEvent = Event::where('event_name', $title)
                    ->where('city_id', $cityId)
                    ->first();

                    if (!$existingEvent) {

                        // Create a new Event instance
                        $event = new Event();
                        $event->event_name = $title;
                        $event->event_name_ar = $title_ar;

                        $event->category_id = $cat->id;
                        $event->region_id = $regionId;
                        $event->city_id = $cityId;
                        // Convert the array to a JSON string
                        $event->event_details = $title;
                        $event->event_image = $image_url;
                        $event->url = $url;
                        $event->start_date = $openDate->format('Y-m-d');
                        $event->end_date = $closeDate->format('Y-m-d');
                        $event->start_time = $openDate->format('H:i:s');
                        $event->end_time =  $closeDate->format('H:i:s');
                        $event->location = $location;
                        $event->location_ar = $location_ar;
                        $event->event_type = $event_type;
                        $event->zone_late = $lat;
                        $event->zone_long = $lon;
                        $event->event_start_price = $price;
                        // Save the event to the database
                        $event->save();




                    }



                }
                echo "Events stored successfully.";

            } else {
                echo "No events found or eventCollection is missing.\n";
            }

        } else {
            echo "Error: " . $statusCode . " - " . $response->getContent(false);
        }
    }

}
