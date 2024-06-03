<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Http\Request;
// use App\Models\Category;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\User;

use Carbon\Carbon;
use Carbon\CarbonInterval;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;


class WhatsappTawilioCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:whatsappTawilio-command';

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
        // Get the current date as start_date
        $start_date = Carbon::now()->toDateString();
    
        // Calculate end_date by adding one week to start_date
        $end_date = Carbon::parse($start_date)->addWeek()->toDateString();
    
        // Query events between start_date and end_date
        $events = Event::where(function ($query) use ($start_date, $end_date) {
            $query->whereBetween('start_date', [$start_date, $end_date])
                ->orWhere('duration', 'AllYear');
        })->get();
    
        $messages = []; // Initialize an empty array to store messages and images
    
        foreach ($events as $event) {
            $title = $event->event_name;
            $url = $event->url;
            $location = $event->location;
            $start_date = $event->start_date;
            $start_time = $event->start_time;
    
            $region = $event->region_id;
            $city = $event->city_id;
            $regionName = "";
            $cityName = "";
            if ($city !== null) {
                $cityName = DB::table('cities')->where('id', $city)->value('name_ar');
            }
            if ($region !== null) {
                $regionName = DB::table('regions')->where('id', $region)->value('name_ar');
            }
            $address = $regionName . '/' . $cityName;
            $image = $event->event_image;
            $message = "$title \n $address\n $url\nDate : $start_date\nTime : $start_time";
    
            // Add the current message and image to the $messages array
            $messages[] = [
                'text' => $message,
                'image' => $image,
            ];
        }
    
        $chunkSize = 3; // Number of events to include in each message
    
        // Split the messages into chunks of size $chunkSize
        $messageChunks = array_chunk($messages, $chunkSize);
    
        // Send each message chunk as a separate Twilio message
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);
        $fromNumber = "+14155238886";
        $users = User::where('service_type', 'whatsapp')->get();
    
        foreach ($messageChunks as $chunk) {

            // Get the events for the current chunk
            $chunkEvents = $events->pluck('id')->toArray();
            foreach ($users as $user) {
                $toNumber = $user->phone;
                $allMessages = '';
                $imageUrls = [];
    
                foreach ($chunk as $message) {
                    $allMessages.= $message['text'] . "\n";
                    $imageUrls[]= $message['image'];
                }
                // foreach ($chunkEvents as $event_id) {
                //     // Check if the user already has the event attached
                //     if (!$user->events->contains($event_id)) {
                //         // Store the user_id, event_id, and is_sent status in the pivot table
                //         $user->events()->attach($event_id, ['is_sent' => true]);
                //     }
                // }
    
                // Send the Twilio message
                $message = $twilio->messages->create(
                    "whatsapp:$toNumber",
                    [
                        "body" => $allMessages,
                        "mediaUrl" => $imageUrls,
                        "from" => "whatsapp:$fromNumber",
                        "Content-Type" => "text/html"
                    ]
                );
            }
        }
    
        $this->info('Message has been sent successfully.');
    }
}