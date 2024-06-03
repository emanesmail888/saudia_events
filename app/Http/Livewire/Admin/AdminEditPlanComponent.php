<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Plan;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminEditPlanComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $price;
    public $image;
    public $plan_id;
    public $newImage;
    public function render()
    {
        return view('livewire.admin.admin-edit-plan-component')->layout('layouts.admin');
    }

    public function mount($plan_id)
    {
        $plan=Plan::where('id',$plan_id)->first();

        $this->description=$plan->description;
        $this->name=$plan->name;
        $this->price=$plan->price;
        $this->image=$plan->image;



    }



    public function updated($fields){

        $this->validateOnly($fields,[
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'price'=>'required',

        ]);

    }

    public function updatePlan()
    {
        $this->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'price'=>'required',

        ]);
        $plan=plan::findOrFail($this->plan_id);
        $plan->name=$this->name;
        $plan->description=$this->description;
        $plan->price=$this->price;
        if($this->newImage)
        {
            $imageName=Carbon::now()->timestamp.'.'.$this->newImage->getClientOriginalName();
            $this->newImage->storeAs('plans',$imageName);
            $plan->image=$imageName;
         }
         $plan->save();


        session()->flash('message','Plan has been updated successfully');
        $this-> name="";
        $this-> description="";
        $this-> price="";
   }


}
