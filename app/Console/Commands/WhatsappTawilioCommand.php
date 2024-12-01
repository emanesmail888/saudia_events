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
    protected $description = 'Send Whatsapp messages With All Interests And All Favourite Regions For Users Premuim Users With active Supscription';

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

    
        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);
        $fromNumber = "+14155238886";
    
        // $users = User::where('service_type', 'whatsapp')->get();
    
        $users = User::with(['categories', 'subcategories','regions'])
        ->whereHas('services', function ($query) {
            $query->whereRaw('JSON_CONTAINS(communication_channels, ?)', ['["whatsapp"]']);
        })->get();
        
        foreach ($users as $user) {
            $userCategories = $user->categories;
            $userRegions= $user->regions;
            $userSubcategories = $user->subcategories;
            $premiumSubscription = $user->supscriptions()->where('status', '=', 'active')->latest('created_at')->first();
            if ($premiumSubscription != null) {


                // Query events between start_date and end_date
                $events = Event::whereHas('region', function ($query) use ($userRegions) {
                    $query->whereIn('id', $userRegions->pluck('id'));
                })
                ->whereHas('categories', function ($query) use ($userCategories) {
                        $query->whereIn('id', $userCategories->pluck('id'));
                })
               
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('end_date', '>=', $start_date)
                         ->whereBetween('end_date', [$start_date, $end_date])
                         ->where('start_date','>=',$start_date);
                    })
                    ->orWhere('duration', 'AllYear');
                        // ->orWhere('event_type', 'Seasons_event')
                        // ->orWhere('event_type', 'featured_events');
                        
                        
                })
                ->get();
                
                $totalEvents = $events->count();
                echo($totalEvents);
                $batchSize = 10;

                $sentEventIds = $user->whats_events()->pluck('id')->toArray();
                $unsentEventIds = $events->whereNotIn('id', $sentEventIds)->pluck('id')->toArray();
                $toNumber = $user->phone;
        
                // Send the first 10 unsent events
                $firstChunk = collect($unsentEventIds)->take($batchSize);
                if (!$firstChunk->isEmpty()) {
                    foreach ($firstChunk as $eventId) {
                        $event = $events->find($eventId);
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
        
                        // Send the Twilio message
                        $twilioMessage = $twilio->messages->create(
                            "whatsapp:$toNumber",
                            [
                                "body" => $message,
                                "mediaUrl" => $image,
                                "from" => "whatsapp:$fromNumber",
                                "Content-Type" => "text/html"
                            ]
                        );
                        $user->events()->attach($eventId, ['send_by_whats' => true]);
                    }
                }
            }
        }
        $this->info('Messages have been sent successfully.');
        return 0;
    }
}