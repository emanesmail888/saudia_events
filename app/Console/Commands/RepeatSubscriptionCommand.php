<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\Region;
use App\Models\City;
use App\Models\Category;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use App\Mail\ExpiredEventMail;
use App\Models\Supscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RepeatSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repeat:userSubscription-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repeat Supscription of all users after one month finished ';

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
        $service = Service::where('service_type', '=', 'premium')->firstOrFail();
        $price = $service->price;

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
                       $registration_id= $user_subscription->registrationId;
                       $checkoutId= $user_subscription->checkout_id;
                       $user_id=$user->id;
                       $this->repeatSubscription($registration_id,$checkoutId,$user_id,$price);
                       
                        // Mail::to($user->email)->send(new ExpiredEventMail($user));
                    
                    }

                }

                                 


            }

        
     
    }


    public function repeatSubscription($registration_id,$checkoutId,$user_id,$price){

            $url = "https://eu-test.oppwa.com/v1/registrations/$registration_id/payments";
            $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                        "&paymentType=DB" .
                        "&amount=$price" .
                        "&currency=EUR" .
                        "&standingInstruction.type=UNSCHEDULED" .
                        "&standingInstruction.mode=REPEATED" .
                        "&standingInstruction.source=MIT" ;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                           'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $this->responseData = curl_exec($ch);
            // if(curl_errno($ch)) {
            //     return curl_error($ch);
            // }
            // curl_close($ch);
            // return $responseData;
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpStatusCode >= 200 && $httpStatusCode < 300) {
                // The response is successful
                $data = json_decode($this->responseData, true);
                $payment_id = $data['id'];
                $regstraion_id = $registration_id;
                $total=$data['amount'];
                $amount=$data['amount'];
                $paymentStatus="success";
                $payment_type=$data['paymentType'];
                $currency=$data['currency'];
                $descriptor=$data['descriptor'];
                $code = $data['result']['code'];
                $description = $data['result']['description'];
                $clearingInstituteName = $data['resultDetails']['clearingInstituteName'];
                $score = $data['risk']['score'];
                $buildNumber = $data['buildNumber'];
                $timestamp = $data['timestamp'];
                $ndc = $data['ndc'];
                $standingInstruction_source = $data['standingInstruction']['source'];
                $standingInstruction_type = $data['standingInstruction']['type'];
                $standingInstruction_mode = $data['standingInstruction']['mode'];
                
    
    
    
                $subscription = new Supscription();
                $subscription->user_id = $user_id;
                $subscription->service_id = 2;
                $subscription->starts_at = Carbon::now();
                $subscription->ends_at = Carbon::now()->addMonth();
                $ends_at= $subscription->ends_at;
                $subscription->total = $total;
                $subscription->amount = $amount;
                $subscription->payment_id = $payment_id;
                $subscription->registrationId = $regstraion_id;
                $subscription->checkout_id = $checkoutId;
                $subscription->payment_status = $paymentStatus;
                $subscription->paymentType = $payment_type;
                $subscription->currency = $currency;
                $subscription->descriptor = $descriptor;
                $subscription->code = $code;
                $subscription->description = $description;
                $subscription->clearingInstituteName = $clearingInstituteName;
                $subscription->score = $score;
                $subscription->buildNumber = $buildNumber;
                $subscription->timestamp = $timestamp;
                $subscription->ndc = $ndc;
                $subscription->standingInstruction_source = $standingInstruction_source;
                $subscription->standingInstruction_type = $standingInstruction_type;
                $subscription->standingInstruction_mode = $standingInstruction_mode;
                $subscription->status = "active";
                $subscription->trackable_data  = json_encode([ 
                    'service_type'=> 'premium',
                    
                    ]);
                $subscription->save();
                $this->info('Subscription Renew successfully.');
    
                // return $this->responseData;
                
            } else {
                
                // The response is not successfull.
                return "Error: HTTP status code - $httpStatusCode";
                $this->info('Subscription Failed to Renew.');

            }
            

    }
}
