<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Category;
use App\Models\Region;
use App\Models\Service;
use App\Models\UserService;
use App\Models\Supscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserManageSupscriptionComponent extends Component
{


    public $userCategories;
    public $userSupscriptions;
    public $userRegions;
    public $userServices;
    public $communication_channels;


    public function mount()
    {

        $this->userCategories = Auth::user()->categories;
        $this->userSupscriptions = Auth::user()->supscriptions()->latest('created_at')->first();
       
        $this->userRegions = Auth::user()->regions;
        $this->userServices = Auth::user()->services;
        foreach ($this->userServices  as  $c) {
            $this->communication_channels= json_decode($c->pivot->communication_channels, true);
    
  
          
          }
        
    }


    public function render()
    {

         
        return view('livewire.user.user-manage-supscription-component', [
            
            'userCategories' => $this->userCategories,
            'userSupscriptions' => $this->userSupscriptions,
            'userRegions' => $this->userRegions,
        ])->layout('layouts.guest');
    }

    public function cancel_supscription()
    {
        $user = Auth::user();
        $activeSubscriptions = $user->supscriptions()->where('ends_at', '>', now())->latest('created_at')->first();
    
        if ($activeSubscriptions != null) {
            DB::table('supscriptions')
                ->where('subscription_id',$activeSubscriptions->subscription_id)
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now(),
                ]);
                session()->flash('message', 'your supscription has been cancelled successfully. No Emails or events message will send to you !!!');

            } 
    }



}