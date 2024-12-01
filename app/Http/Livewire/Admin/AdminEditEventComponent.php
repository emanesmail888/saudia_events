<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Region;
use App\Models\City;
use App\Models\Event;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminEditEventComponent extends Component
{

    use WithFileUploads;
    public $event_name;
    public $event_name_ar;
    public $event_details;
    public $start_date;
    public $end_date;
    public $end_time;
    public $start_time;
    public $organizedBy;
    public $event_type;
    public $url;
    public $location;
    public $location_ar;
    public $conditions;
    public $event_image;
    public $duration;
    public $category_id;
    public $region_id;
    public $city_id;
    public $scategory_id;
    public $event_start_price;
    public $zone_late;
    public $zone_long;
    public $event_id;


    public function render()
    {
        $categories=Category::cursor();
        $scategories=Subcategory::where('category_id',$this->category_id)->get();
        $regions=Region::cursor();
        $cities=City::cursor();

        return view('livewire.admin.admin-edit-event-component',['categories'=>$categories,'scategories'=>$scategories,'regions'=>$regions,'cities'=>$cities])->layout('layouts.admin');
    }

    public function mount($event_id)
    {
        $event=Event::where('id',$event_id)->firstOrFail();

        $this->event_details=$event->event_details;
        $this->event_name=$event->event_name;
        $this->event_name_ar=$event->event_name_ar;
        $this->event_start_price=$event->event_start_price;
        $this->duration=$event->duration;
        $this->conditions=$event->conditions;
        $this->start_date=$event->start_date;
        $this->start_time= $event->start_time;
        $this->end_time= $event->end_time;
        // $event->start_time=date('H:i:s', strtotime($this->start_time));
        // $event->end_time=date('H:i:s', strtotime($this->end_time));
        $this->event_type=$event->event_type;
        $this->end_date=$event->end_date;
        $this->organizedBy=$event->organizedBy;
        $this->location=$event->location;
        $this->location_ar=$event->location_ar;
        $this->url=$event->url;
        $this->zone_late=$event->zone_late;
        $this->zone_long=$event->zone_long;

        $this->event_image=$event->event_image;

        $this->category_id=$event->category_id;
        $this->region_id=$event->region_id;
        $this->city_id=$event->city_id;
        $this->scategory_id=   $event->subcategory_id;


    }

    public function changeSubcategory()
    {
        $this->scategory_id=0;
    }

    public function updated($fields){

        $this->validateOnly($fields,[
            'event_name'=>'required',
            'event_details'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'end_time'=>'required',
            'start_time'=>'required',
            'event_image'=>'required',
            'duration'=>'numeric',
            'category_id'=>'required',
            'region_id'=>'required',
            'city_id'=>'required',
            'event_start_price'=>'required',
            'location'=>'required',
            'location_ar'=>'required',


        ]);

    }

    public function updateEvent()
    {
        $this->validate([
            'event_name'=>'required',
            'event_details'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'end_time'=>'required',
            'start_time'=>'required',
            'event_image'=>'required',
            'duration'=>'numeric',
            'category_id'=>'required',
            'region_id'=>'required',
            'city_id'=>'required',
            'event_start_price'=>'required',
            'location'=>'required',
            'location_ar'=>'required',

        ]);
        $event=Event::find($this->event_id);
        $event->event_name=$this->event_name;
        $event->event_name_ar=$this->event_name_ar;
        $event->event_details=$this->event_details;
        $event->event_start_price=$this->event_start_price;
        $event->duration=$this->duration;
        $event->conditions=$this->conditions;
        $event->start_date=$this->start_date;
        $event->end_date=$this->end_date;
        $event->start_time=date('H:i:s', strtotime($this->start_time));
        $event->end_time=date('H:i:s', strtotime($this->end_time));
        $event->event_type=$this->event_type;
        $event->organizedBy=$this->organizedBy;
        $event->location=$this->location;
        $event->location_ar=$this->location_ar;
        $event->url=$this->url;
        $event->zone_late=$this->zone_late;
        $event->zone_long=$this->zone_long;
        $event->event_image=$this->event_image;

        $event->category_id=$this->category_id;
        $event->region_id=$this->region_id;
        $event->city_id=$this->city_id;
        if($this->scategory_id)

        {
            $event->subcategory_id=$this->scategory_id;
        }


         $event->save();


        session()->flash('message','Event has been updated successfully');
        $this-> event_name="";
        $this-> event_name_ar="";
        $this-> event_details="";
        $this-> start_date="";
        $this-> end_date="";
        $this-> end_time="";
        $this-> start_time="";
        $this-> organizedBy="";
        $this-> event_type="";
        $this-> url="";
        $this-> location="";
        $this-> location_ar="";
        $this-> event_image="";
        $this-> duration="";
        $this-> category_id="";
        $this-> region_id="";
        $this-> city_id="";
        $this-> scategory_id="";
        $this-> event_start_price="";
        $this-> zone_late="";
        $this-> zone_long="";
   }


}
