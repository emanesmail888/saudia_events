<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Plan;

class AdminPlanComponent extends Component
{

    public function render()
    {
        $plans=Plan::cursor();

        return view('livewire.admin.admin-plan-component',['plans'=>$plans])->layout('layouts.admin');
    }


    public function deletePlan($id)
    {
        $plan=Plan::findOrFail($id);
        $plan->delete();
        session()->flash('message','Plan has been deleted successfully!');

    }


}
