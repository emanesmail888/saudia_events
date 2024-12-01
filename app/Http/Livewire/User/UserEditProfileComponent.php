<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEditProfileComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $mobile;
    public $address;
    public $city;
    public $country;
    public $zipcode;
    public $image;
    public $newImage;


    public function mount(){
        $user=User::find(Auth::user()->id);
        $this->name=$user->name;
        $this->email=$user->email;
        $this->mobile=$user->profile->mobile;
        $this->image=$user->profile->image;
        $this->address=$user->profile->address;
        $this->city=$user->profile->city;
        $this->country=$user->profile->country;
        $this->zipcode=$user->profile->zipcode;
    }
    public function updateProfile(){
        $user=User::find(Auth::user()->id);
        $user->name=$this->name;
        $user->phone=$this->mobile;
        $user->save();
        $user->profile->mobile=$this->mobile;
        $user->profile->address=$this->address;
        $user->profile->city=$this->city;
        $user->profile->country=$this->country;
        $user->profile->zipcode=$this->zipcode;
        if($this->newImage)
        {
            if($this->image)
            {
                unlink('assets/images/profile/',$this->image);
            }
            $imageName=Carbon::now()->timestamp.'.'.$this->newImage->getClientOriginalName();
            $this->newImage->storeAs('profile',$imageName);
            $user->profile->image=$imageName;
         }
        $user->profile->save();

         session()->flash('message','Profile has been updated successfully');




    }
    public function render()
    {
        $user=User::find(Auth::user()->id);

        return view('livewire.user.user-edit-profile-component',['user'=>$user])->layout('layouts.home');
    }
}

   

