<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Plan;
use Carbon\Carbon;
use Livewire\WithFileUploads;


use Illuminate\Support\Str;

class AdminAddPlanComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $price;
    public $image;
    public function render()
    {
        return view('livewire.admin.admin-add-plan-component')->layout('layouts.admin');
    }



    public function updated($fields){

        $this->validateOnly($fields,[
             'name'=>'required',
             'description'=>'required',
             'image'=>'required',
             'price'=>'required',


        ]);



    }



    public function storePlan(){
        $this->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'price'=>'required',
        ]);
        $plan=new Plan();
        $plan->name=$this->name;
        $plan->description=$this->description;
        $plan->price=$this->price;
        $imageName="";
        if($this->image){
        $imageName=Carbon::now()->timestamp.'.'.$this->image->getClientOriginalName();
         $this->image->storeAs('plans',$imageName);
        }
        $plan->image=$imageName;
        $plan->save();


        session()->flash('message','Plan has been created successfully');

         $this-> name="";
         $this-> description="";
         $this-> price="";

    }

}
