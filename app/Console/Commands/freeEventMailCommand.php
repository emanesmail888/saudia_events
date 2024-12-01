<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\UserService;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use App\Mail\EventMail;
use App\Jobs\SendEventMailJob;
use Illuminate\Support\Facades\Mail;

class freeEventMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:freeEventMail_command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email With First Interest For Users Free Supscriptions Or Premuim Users With Inactive Supscription';

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

        $users = User::with(['categories', 'subcategories', 'regions'])
            ->whereHas('services', function ($query) {
                $query->whereRaw('JSON_CONTAINS(communication_channels, ?)', ['["email"]']);
            })->get();

        $batchSize = 10;

        foreach ($users as $user) {
            $userCategories = $user->categories->first(); // Get the first user category
            $userRegions = $user->regions;
            $userSubcategories = $user->subcategories;

            $userServices = $user->services;
            $service_type = "";

            foreach ($userServices as $service) {
                $service_type = $service->service_type;
            }

            $inactivePremiumSubscription = $user->supscriptions()->where('status', '=', 'inactive')->latest('created_at')->first();
            if ($inactivePremiumSubscription != null || $service_type == "free") {
                $events = Event::whereHas('region', function ($query) use ($userRegions) {
                    $query->whereIn('id', $userRegions->pluck('id'));
                })
                ->whereHas('categories', function ($query) use ($userCategories) {
                    $query->where('id', $userCategories->id);
                })
               
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('end_date', '>=', $start_date)
                         ->whereBetween('end_date', [$start_date, $end_date])
                         ->where('start_date','>=',$start_date);
                    })
                    ->orWhere('duration', 'AllYear');
                             
                        
                })
                ->get();
                $totalEvents = $events->count();
                echo($totalEvents);

                $sentEventIds = $user->events()->pluck('id')->toArray();
                $unsentEventIds = $events->whereNotIn('id', $sentEventIds)->pluck('id')->toArray();

                // Send the first 10 unsent events
                $firstChunk = collect($unsentEventIds)->take($batchSize);
                if (!$firstChunk->isEmpty()) {
                    Mail::to($user->email)->send(new EventMail($events->whereIn('id', $firstChunk), $user));
                    $user->events()->attach($firstChunk, ['is_sent' => true]);
                }
            }
        }

        return 0;
    }
}
