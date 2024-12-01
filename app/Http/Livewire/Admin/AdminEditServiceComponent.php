<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Service;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminEditServiceComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $service_type;
    public $price;
    public $image;
    public $details;
    public $service_id;
    public $newImage;
    public function render()
    {
        return view('livewire.admin.admin-edit-service-component')->layout('layouts.admin');
    }

    public function mount($service_id)
    {
        $service=Service::where('id',$service_id)->firstOrFail();

        $this->service_type=$service->service_type;
        $this->name=$service->name;
        $this->price=$service->price;
        $this->image=$service->image;
        $this->details=$service->details;



    }



    public function updated($fields){

        $this->validateOnly($fields,[
            'name'=>'required',
            'service_type'=>'required',
            // 'image'=>'required',
            'price'=>'required',
            'details'=>'required',

        ]);

    }

    public function updateService()
    {
        $this->validate([
            'name'=>'required',
            'service_type'=>'required',
            // 'image'=>'required',
            'price'=>'required',
            'details'=>'required',

        ]);
        $service=Service::findOrFail($this->service_id);
        $service->name=$this->name;
        $service->service_type=$this->service_type;
        $service->price=$this->price;
        $service->details=$this->details;
        if($this->newImage)
        {
            $imageName=Carbon::now()->timestamp.'.'.$this->newImage->getClientOriginalName();
            $this->newImage->storeAs('services',$imageName);
            $service->image=$imageName;
         }
         $service->save();


        session()->flash('message','Service has been updated successfully');
        $this-> name="";
        $this-> service_type="";
        $this-> price="";
        $this-> details="";
   }


}
