<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\DB;
use App\Mail\EventMail;
use Illuminate\Support\Facades\Mail;




class EventsMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:eventMail_command';

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
         //  $events = Event::whereBetween('start_date', [$start_date, $end_date])->get();
          $events = Event::where(function ($query) use ($start_date, $end_date) {
              $query->whereBetween('start_date', [$start_date, $end_date])
                  ->orWhere('duration', 'AllYear');
          })->get();

          $users = User::where('service_type', 'email')->get();
          foreach ($users as $user) {


           Mail::to($user->email)->send(new EventMail($events,$user));
        //    $user->events()->attach($events->id, ['is_sent' => true]);


          }

    }
}
