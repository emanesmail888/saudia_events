<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\Category;
use App\Models\Region;
use App\Models\Service;
use App\Models\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class UserDashboardComponent extends Component
{

    public $regions;
    public $categories;
    public $service_type;
    public $user_service;
    public $checkAllCategory = false;
    protected  $cats;



    public $userCategories;
    public $userSupscriptions;
    public $userRegions;
    public $userServices;
    public $premium_email = false;
    public $free_email = false;
    public $whatsapp = false;
    public $communication_channels;
    public $hasPhone = false;
    public $phone;
    public $country_code;
   

    public function mount()
    {

        $this->userCategories = Auth::user()->categories;
        $this->userSupscriptions = Auth::user()->supscriptions()->latest('created_at')->first();
        $this->cats = Category::cursor();

       
        $this->userRegions = Auth::user()->regions;
        $this->userServices = Auth::user()->services;
        foreach ($this->userServices  as  $c) {
          $this->service_type=$c['service_type'];
          $this->communication_channels= json_decode($c->pivot->communication_channels, true);
          if( $this->service_type === 'free'){
            $this->free_email = in_array('email', $this->communication_channels);
          }
          else{
            $this->premium_email = in_array('email', $this->communication_channels);
            $this->whatsapp = in_array('whatsapp', $this->communication_channels);

          }

         
         
        }


        $this->categories = $this->userCategories->pluck('id')->toArray();
        $this->regions = $this->userRegions->pluck('id')->toArray();
        $this->user_service = new UserService();
        $this->hasPhone = auth()->user()->phone === "" || auth()->user()->phone === null;


        

    }


   
    


    public function render()
    {
        $this->cats = Category::cursor();
        $regs = Region::cursor();
        $services=Service::cursor();
        $service_type="";

        foreach ($services  as  $service) {
        $service_type=$service->service_type;
        }

        return view('livewire.user.user-dashboard-component', [
            'cats' => $this->cats,
            'regs' => $regs,
            'services'=>$services,
            'userCategories' => $this->userCategories,
            'userSupscriptions' => $this->userSupscriptions,
            'userRegions' => $this->userRegions,
            'service_type' => $service_type,
        ])->layout('layouts.guest');
    }

    public function toggleCheckAll()
    {
        $this->cats = Category::all();
        $this->checkAllCategory = !$this->checkAllCategory;
        $this->categories = $this->checkAllCategory ? $this->cats->pluck('id')->toArray() : [];
    }

    

















    

    public function updated($fields){

        $this->validateOnly($fields,[
            'categories' => 'required|array',
            'service_type' => 'required|string',
            'regions' => 'required|array',


        ]);



    }

    protected $messages = [
        'phone.digits' => 'The phone number must be exactly 10 digits long.',
    ];

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
        $user->regions()->sync($this->regions);
        
        $user->save();
    
        // Update the user's service
        $service = Service::where('service_type', $this->service_type)->firstOrFail();
        $this->user_service->service_id = $service->id;
    
        $this->communication_channels = [];
    
        if ($this->service_type === 'premium') {
            if ($this->premium_email) {
                $this->communication_channels[] = 'email';
            }
            if ($this->whatsapp) {
                $this->communication_channels[] = 'whatsapp';
            }

            $this->user_service->communication_channels = json_encode($this->communication_channels);
            $user = auth()->user();
            $user->update([
                'phone' =>$this->country_code.$this->phone
            ]);
            $user->save();
    
           
        } else {
            if ($this->free_email) {
                $this->communication_channels[] = 'email';
            }
            $this->user_service->communication_channels = json_encode($this->communication_channels);
        }
    
        $this->user_service->user_id = $user->id;
        $user->services()->sync([$this->user_service->service_id => ['communication_channels' => $this->user_service->communication_channels]]);
    
        session()->flash('message', 'User categories and regions have been updated successfully.');
    }

 
  

   
}





