<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class SubscriptionComponent extends Component
{
    public function render()
    {
        $this->verifyForCheckout();

        return view('livewire.subscription-component')->layout('layouts.home');
    }


    public function verifyForCheckout(){
        if (!Auth::check())
        {
            return redirect()->route('login');
        }
        
        elseif (!Session()->get('subscribe'))
         {
            return redirect()->route('home');
        }

        else {
            # code...
        }

    }
}
