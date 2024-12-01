<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\WithFileUploads;


use Illuminate\Support\Str;

class AdminAddServiceComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $service_type;
    public $price;
    public $image;
    public $details;
    public function render()
    {
        return view('livewire.admin.admin-add-service-component')->layout('layouts.admin');
    }



    public function updated($fields){

        $this->validateOnly($fields,[
             'name'=>'required',
             'service_type'=>'required',
            //  'image'=>'required',
             'price'=>'required',
             'details'=>'required',


        ]);



    }



    public function storeService(){
        $this->validate([
            'name'=>'required',
            'service_type'=>'required',
            // 'image'=>'required',
            'price'=>'required',
            'details'=>'required',

        ]);
        $service=new Service();
        $service->name=$this->name;
        $service->service_type=$this->service_type;
        $service->price=$this->price;
        $service->details=$this->details;
        $imageName="";
        if($this->image){
        $imageName=Carbon::now()->timestamp.'.'.$this->image->getClientOriginalName();
         $this->image->storeAs('services',$imageName);
        }
        $service->image=$imageName;
        $service->save();


        session()->flash('message','Plan has been created successfully');

         $this-> name="";
         $this-> service_type="";
         $this-> price="";
         $this-> details="";

    }

}
