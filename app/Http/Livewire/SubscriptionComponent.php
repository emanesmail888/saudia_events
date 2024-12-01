<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Service;


class SubscriptionComponent extends Component
{
    

    public $checkoutId;
    public $responseData;
    public $price;
    public $service;


    public function mount()
    {

        $this->service = Service::where('service_type', '=', 'premium')->firstOrFail();
        $this->price = $this->service->price;
        $this->setPriceForSubscribe();
        $this->verifyForCheckout();
    }

    public function render()
    {

        return view('livewire.subscription-component') ->layout('layouts.home');
    }

    public function verifyForCheckout()
    {
        if (!Auth::check())
        {
            return redirect()->route('login');
        }
        
        elseif (!Session()->get('subscribe'))
        {
            return redirect()->route('home');
        }
        else
        {
            $responseData = $this->request($this->price);
            $response = json_decode($responseData, true);
            $this->checkoutId = $response['id'];
        }
    }

    public function setPriceForSubscribe(){
       
        Session()->put('subscribe',[
           
            'total'=> $this->price,
        ]);


    }

    // protected function request()
    // {
    //         $url = "https://eu-test.oppwa.com/v1/checkouts";
    //         $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
    //                     "&amount=20.00" .
    //                     "&currency=EUR" .
    //                     "&paymentType=DB";
        
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                     'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $responseData = curl_exec($ch);
    //         if(curl_errno($ch)) {
    //             return curl_error($ch);
    //         }
    //         curl_close($ch);
    //         return $responseData;
        
    // }

    protected function request($price) {
        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                    "&testMode=EXTERNAL" .
                    "&createRegistration=true" .
                    "&amount=$price" .
                    "&currency=EUR" .
                    "&paymentType=DB" .
                    "&standingInstruction.mode=INITIAL" .
                    "&standingInstruction.source=CIT" .
                    "&standingInstruction.type=UNSCHEDULED" ;
                  
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                       'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }
  

   
}
