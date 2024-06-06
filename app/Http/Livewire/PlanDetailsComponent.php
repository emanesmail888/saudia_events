<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;



class PlanDetailsComponent extends Component
{
    public $plan_id;
    public $name;
    public $description;
    public $price;

    public function mount($plan_id)
    {
        $plan=Plan::where('id',$plan_id)->firstOrFail();
        $this->description=$plan->description;
        $this->name=$plan->name;
        $this->price=$plan->price;
    }


    public function render()
    {
         $plan=Plan::where('id',$this->plan_id)->firstOrFail();
         $this->setPriceForSubscribe();

        return view('livewire.plan-details-component',['plan'=>$plan])->layout('layouts.home');
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
