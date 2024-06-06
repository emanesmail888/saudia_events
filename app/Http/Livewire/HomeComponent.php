<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Region;
use App\Models\City;
use App\Models\Event;
use App\Models\Plan;

class HomeComponent extends Component
{
    public function render()
    {
        $categories=Category::cursor();
        $regions=Region::cursor();
        $cities=City::cursor();
        $jaddah_city_id = City::where('name_ar', '=', 'جدة')->first()->id;
        $jeddah_events = Event::where('city_id', '=', $jaddah_city_id)->get()->take(9);
        $riyad_city_id = City::where('name_ar', '=', 'الرياض')->first()->id;
        $riyad_events = Event::where('city_id', '=', $riyad_city_id)->get()->take(9);
        $diriah_city_id = City::where('name_ar', '=', 'الدرعية')->first()->id;
        $diriah_events = Event::where('city_id', '=', $diriah_city_id)->get()->take(9);
        $plans=Plan::cursor();
        $experiences_events = Event::where('duration', 'AllYear')->get();



        return view('livewire.home-component',['categories'=>$categories,
        'cities'=>$cities,
        'jeddah_events'=>$jeddah_events,
        'regions'=>$regions,
        'riyad_events'=>$riyad_events,
        'diriah_events'=>$diriah_events,
        'riyad_city_id'=>$riyad_city_id,
        'jaddah_city_id'=>$jaddah_city_id,
        'diriah_city_id'=>$diriah_city_id,
        'plans'=>$plans,
        'experiences_events'=>$experiences_events,
        ])->layout('layouts.home');
    }
}
