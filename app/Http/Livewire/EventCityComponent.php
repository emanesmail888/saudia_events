<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\City;
use App\Models\Event;
use Illuminate\Support\Facades\DB;



class EventCityComponent extends Component
{
    public $city_id;
    
    public function mount($city_id)
    {
        $this->city_id = $city_id;
    }

    public function render()
    {
        $city = DB::table('cities')->where('id', $this->city_id)->first();
        $events_city=Event::where('city_id',$this->city_id)->paginate(15);

        return view('livewire.event-city-component',['events_city'=>$events_city,'city'=>$city])->layout('layouts.home');
    }
}
