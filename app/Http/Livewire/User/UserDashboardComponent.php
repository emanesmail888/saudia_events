<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;



class UserDashboardComponent extends Component
{

    public $regions;
    public $categories;
    public $service_type;


    public function render()
    {
        $cats=Category::cursor();
        $regs=Region::cursor();
        $userCategories = Auth::user()->categories;
        $userRegions = Auth::user()->regions;
        $service = Auth::user()->service_type;


        return view('livewire.user.user-dashboard-component',['cats'=>$cats,'regs'=>$regs,'userCategories'=>$userCategories,'userRegions'=>$userRegions,'service'=>$service])->layout('layouts.home');
    }

    public function updated($fields){

        $this->validateOnly($fields,[
            'categories' => 'required|array',
            'service_type' => 'required|string',
            'regions' => 'required|array',


        ]);



    }

    public function updateDashboard()
{


    // Validate the form data
    $this->validate([
        'categories' => 'required|array',
        'service_type' => 'required|string',
        'regions' => 'required|array',
    ]);

    // Update the user's dashboard data
    $user = auth()->user();
    $user->categories()->sync($this->categories);
    if ($this->service_type === 'whatsapp') {
        $user->service_type ="whatsapp";
    }
    else{
        $user->service_type ="email";


    }
    $user->regions()->sync($this->regions);
    $user->save();

    session()->flash('message','UserCategories And UserRegions has been created successfully');
}

public function updateDashboardv(){
        $this->validate([
            'service_type'=>'required',
            'categories' => 'required',
            'regions' => 'required',


        ]);
        $user = Auth::user();

        $user->regions()->sync($this->regions);
        $user->categories()->sync($this->categories);

        $user->service_type = $this->service_type;
        $user->save();

        session()->flash('message','UserCategories And UserRegions has been created successfully');


        }

}
