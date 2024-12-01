<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;



class ServiceDetailsComponent extends Component
{
    public $service_id;
    public $name;
    public $description;
    public $price;

    public function mount($service_id)
    {
        $service=Service::where('id',$service_id)->firstOrFail();
        $this->description=$service->description;
        $this->name=$service->name;
        $this->price=$service->price;
    }


    public function render()
    {
         $service=Service::where('id',$this->service_id)->firstOrFail();
         $this->setPriceForSubscribe();

        return view('livewire.service-details-component',['service'=>$service])->layout('layouts.home');
    }


    public function subscribe(){
        if(Auth::check())
        {

            return redirect()->route('subscribe');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function setPriceForSubscribe(){
       
            Session()->put('subscribe',[
               
                'total'=> $this->price,
            ]);
    
    
    }
}
