<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class setInactiveSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:inactiveSubscription-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Users That Subscription ended status to inactive ';

    

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
        $now = now();

        $users = User::with(['supscriptions'])->get();

            foreach ($users as $user ) {
                $user_subscription=$user->supscriptions()->latest('created_at')->first();
                if ($user_subscription != null) {
                    if($user_subscription->ends_at < now()){
                        DB::table('supscriptions')
                        ->where('payment_id',$user_subscription->payment_id)
                        ->update([
                            'status' => 'inactive',
                            'updated_at' => now(),
                        ]);
                    }
                }
               
            }    
            $this->info('Subscription inactive successfully.');
               
    }
}
