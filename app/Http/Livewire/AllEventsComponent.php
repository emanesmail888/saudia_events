<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\Category;
use App\Models\City;
use App\Models\Region;
use Livewire\WithPagination;

class AllEventsComponent extends Component
{
    public function render()
    {
        $events=Event::paginate(12);
        $categories=Category::cursor();
        $regions=Region::cursor();
        $cities=City::cursor();
        return view('livewire.all-events-component',['events'=>$events,'categories'=>$categories,'regions'=>$regions,'cities'=>$cities])->layout('layouts.home');
    }
}
