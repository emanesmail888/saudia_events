<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Mail\ExpiredEventMail;
use App\Models\Supscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;



class SendExpiredEventMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:expiredSupscriptionEmail-command';

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

        // Calculate end_date by adding 3 days to start_date
        $end_date = Carbon::parse($start_date)->addDays(3)->toDateString();

        // Get all users with their subscriptions
        $users = User::with(['supscriptions'])->get();

        $expiringUsers = [];

        foreach ($users as $user) {
            $latestSubscription = $user->supscriptions()->latest('created_at')->first();
            
            if ($latestSubscription != null) {
                if ($latestSubscription->ends_at >= Carbon::parse($start_date)->toDateString() && $latestSubscription->ends_at <= Carbon::parse($end_date)->toDateString()) {
                    $expiringUsers[] = [
                        'user' => $user,
                        'ends_at' => $latestSubscription->ends_at,
                    ];
                }
            }
        }

        // Now you can use the $expiringUsers array to send notifications or perform any other actions
        foreach ($expiringUsers as $expiringUser) {
            Mail::to($expiringUser['user']->email)->send(new ExpiredEventMail($expiringUser['user'], $expiringUser['ends_at']));
        }

      
        
     
    }


    
}
