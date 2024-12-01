<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Supscription;
use Illuminate\Support\Facades\Auth;





class CheckoutStatusComponent extends Component
{
   
    public $responseData;

    public function render()
    {
        return view('livewire.checkout-status-component') ->layout('layouts.home');
    }
    
    public function mount()
    {
        $this->status();
    }



    protected function status()
    {
        // Get the full request URI
        $requestUri = $_SERVER['REQUEST_URI'];

        // Parse the request URI to extract the query string
        $parsedUrl = parse_url($requestUri);

        // Parse the query string to get the 'resourcePath' value
        $queryParams = [];
        parse_str($parsedUrl['query'], $queryParams);

        $resourcePath = $queryParams['resourcePath'];
        $checkoutId = $queryParams['id'];
        $this->responseData = $this->request_status($resourcePath,$checkoutId);
        return $this->responseData;

    }

    // protected function request_status($resource_path,$checkoutId)
    // {

    //     $url = "https://eu-test.oppwa.com.$resource_path";
    //     $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                 'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $this->responseData = curl_exec($ch);
    //     // if(curl_errno($ch)) {
    //     //     return curl_error($ch);
    //     // }
    //     // curl_close($ch);
    //     // return $responseData;


    //     $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);
    
    //     if ($httpStatusCode >= 200 && $httpStatusCode < 300) {
    //         // The response is successful
    //         //echo('Success');
    //         $data = json_decode($this->responseData, true);
    //         $subscription_id = $data['id'];
    //         $total=$data['amount'];
    //         $amount=$data['amount'];
    //         $paymentStatus="success";
    //         $payment_type=$data['paymentType'];
    //         $brand=$data['paymentBrand'];
    //         $currency=$data['currency'];
    //         $descriptor=$data['descriptor'];
    //         $code = $data['result']['code'];
    //         $description = $data['result']['description'];
    //         $clearingInstituteName = $data['resultDetails']['clearingInstituteName'];
    //         $bin = $data['card']['bin'];
    //         $lastDigits = $data['card']['last4Digits'];
    //         $holder = $data['card']['holder'];
    //         $expiryMonth = $data['card']['expiryMonth'];
    //         $expiryYear = $data['card']['expiryYear'];
    //         $bank = $data['card']['issuer']['bank'];
    //         $type = $data['card']['type'];
    //         $level = $data['card']['level'];
    //         $country = $data['card']['country'];
    //         $maxPanLength = $data['card']['maxPanLength'];
    //         $binType = $data['card']['binType'];
    //         $regulatedFlag = $data['card']['regulatedFlag'];
    //         $ip = $data['customer']['ip'];
    //         $ipCountry = $data['customer']['ipCountry'];
    //         $value = $data['customer']['browserFingerprint']['value'];
    //         $eci = $data['threeDSecure']['eci'];
    //         $SHOPPER_EndToEndIdentity = $data['customParameters']['SHOPPER_EndToEndIdentity'];
    //         $CTPE_DESCRIPTOR_TEMPLATE = $data['customParameters']['CTPE_DESCRIPTOR_TEMPLATE'];
    //         $score = $data['risk']['score'];
    //         $buildNumber = $data['buildNumber'];
    //         $timestamp = $data['timestamp'];
    //         $ndc = $data['ndc'];




    //         $subscription = new Supscription();
    //         $subscription->user_id = Auth::user()->id;
    //         $subscription->service_id = 2;
    //         $subscription->starts_at = Carbon::now();
    //         $subscription->ends_at = Carbon::now()->addMonth();
    //         $ends_at= $subscription->ends_at;
    //         $subscription->total = $total;
    //         $subscription->amount = $amount;
    //         $subscription->subscription_id = $subscription_id;
    //         $subscription->checkout_id = $checkoutId;
    //         $subscription->payment_status = $paymentStatus;
    //         $subscription->paymentType = $payment_type;
    //         $subscription->currency = $currency;
    //         $subscription->descriptor = $descriptor;
    //         $subscription->code = $code;
    //         $subscription->description = $description;
    //         $subscription->clearingInstituteName = $clearingInstituteName;
    //         $subscription->bin = $bin;
    //         $subscription->lastDigits = $lastDigits;
    //         $subscription->holder = $holder;
    //         $subscription->expiryMonth = $expiryMonth;
    //         $subscription->expiryYear = $expiryYear;
    //         $subscription->bank = $bank;
    //         $subscription->type = $type;
    //         $subscription->level = $level;
    //         $subscription->country = $country;
    //         $subscription->maxPanLength = $maxPanLength;
    //         $subscription->binType = $binType;
    //         $subscription->regulatedFlag = $regulatedFlag;
    //         $subscription->ip = $ip;
    //         $subscription->ipCountry = $ipCountry;
    //         $subscription->value = $value;
    //         $subscription->eci = $eci;
    //         $subscription->SHOPPER_EndToEndIdentity = $SHOPPER_EndToEndIdentity;
    //         $subscription->CTPE_DESCRIPTOR_TEMPLATE = $CTPE_DESCRIPTOR_TEMPLATE;
    //         $subscription->score = $score;
    //         $subscription->buildNumber = $buildNumber;
    //         $subscription->timestamp = $timestamp;
    //         $subscription->ndc = $ndc;
    //         $subscription->brand = $brand;
    //         $subscription->status = "active";
    //         $subscription->trackable_data  = json_encode([ 
    //             'service_type'=> 'premium',
                
    //             ]);
    //         $subscription->save();
    //         Session()->flash('success','Thanks,Your subscription has been successfully set! your subscription will ended in'.$ends_at);



    //         // return $this->responseData;
            
    //     } else {
            
    //         // The response is not successful
    //         Session()->flash('fail','Your subscription Failed ! You can try again.');

    //         return "Error: HTTP status code - $httpStatusCode";
    //     }
    // }

    protected function request_status($resource_path,$checkoutId)
    {
        // $url = "https://eu-test.oppwa.com/v1/checkouts/{id}/payment";
        $url = "https://eu-test.oppwa.com/v1/checkouts/$checkoutId/payment";

        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
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
            $regstraion_id = $data['registrationId'];
            $total=$data['amount'];
            $amount=$data['amount'];
            $paymentStatus="success";
            $payment_type=$data['paymentType'];
            $brand=$data['paymentBrand'];
            $recurringType=$data['recurringType'];
            $currency=$data['currency'];
            $descriptor=$data['descriptor'];
            $code = $data['result']['code'];
            $description = $data['result']['description'];
            $clearingInstituteName = $data['resultDetails']['clearingInstituteName'];
            $bin = $data['card']['bin'];
            $lastDigits = $data['card']['last4Digits'];
            $holder = $data['card']['holder'];
            $expiryMonth = $data['card']['expiryMonth'];
            $expiryYear = $data['card']['expiryYear'];
            $bank = $data['card']['issuer']['bank'];
            $type = $data['card']['type'];
            $level = $data['card']['level'];
            $country = $data['card']['country'];
            $maxPanLength = $data['card']['maxPanLength'];
            $binType = $data['card']['binType'];
            $regulatedFlag = $data['card']['regulatedFlag'];
            $ip = $data['customer']['ip'];
            $ipCountry = $data['customer']['ipCountry'];
            $value = $data['customer']['browserFingerprint']['value'];
            $eci = $data['threeDSecure']['eci'];
            $SHOPPER_EndToEndIdentity = $data['customParameters']['SHOPPER_EndToEndIdentity'];
            $CTPE_DESCRIPTOR_TEMPLATE = $data['customParameters']['CTPE_DESCRIPTOR_TEMPLATE'];
            $score = $data['risk']['score'];
            $buildNumber = $data['buildNumber'];
            $timestamp = $data['timestamp'];
            $ndc = $data['ndc'];
            $standingInstruction_source = $data['standingInstruction']['source'];
            $standingInstruction_type = $data['standingInstruction']['type'];
            $standingInstruction_mode = $data['standingInstruction']['mode'];
            



            $subscription = new Supscription();
            $subscription->user_id = Auth::user()->id;
            $subscription->service_id = 2;
            $subscription->starts_at = Carbon::now();
            $subscription->ends_at = Carbon::now()->addMonth();
            $ends_at= $subscription->ends_at;
            $subscription->total = $total;
            $subscription->amount = $amount;
            $subscription->payment_id = $payment_id;
            $subscription->registrationId = $regstraion_id;
            $subscription->recurringType = $recurringType;
            $subscription->checkout_id = $checkoutId;
            $subscription->payment_status = $paymentStatus;
            $subscription->paymentType = $payment_type;
            $subscription->currency = $currency;
            $subscription->descriptor = $descriptor;
            $subscription->code = $code;
            $subscription->description = $description;
            $subscription->clearingInstituteName = $clearingInstituteName;
            $subscription->bin = $bin;
            $subscription->lastDigits = $lastDigits;
            $subscription->holder = $holder;
            $subscription->expiryMonth = $expiryMonth;
            $subscription->expiryYear = $expiryYear;
            $subscription->bank = $bank;
            $subscription->type = $type;
            $subscription->level = $level;
            $subscription->country = $country;
            $subscription->maxPanLength = $maxPanLength;
            $subscription->binType = $binType;
            $subscription->regulatedFlag = $regulatedFlag;
            $subscription->ip = $ip;
            $subscription->ipCountry = $ipCountry;
            $subscription->value = $value;
            $subscription->eci = $eci;
            $subscription->SHOPPER_EndToEndIdentity = $SHOPPER_EndToEndIdentity;
            $subscription->CTPE_DESCRIPTOR_TEMPLATE = $CTPE_DESCRIPTOR_TEMPLATE;
            $subscription->score = $score;
            $subscription->buildNumber = $buildNumber;
            $subscription->timestamp = $timestamp;
            $subscription->ndc = $ndc;
            $subscription->standingInstruction_source = $standingInstruction_source;
            $subscription->standingInstruction_type = $standingInstruction_type;
            $subscription->standingInstruction_mode = $standingInstruction_mode;
            $subscription->brand = $brand;
            $subscription->status = "active";
            $subscription->trackable_data  = json_encode([ 
                'service_type'=> 'premium',
                
                ]);
            $subscription->save();
            Session()->flash('success','Thanks,Your subscription has been successfully set! your subscription will ended in'.$ends_at);



            // return $this->responseData;
            
        } else {
            
            // The response is not successful
            Session()->flash('fail','Your subscription Failed ! You can try again.');

            return "Error: HTTP status code - $httpStatusCode";
        }
    }
    

   



}

