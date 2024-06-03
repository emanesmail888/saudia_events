<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contact;
use App\Models\Setting;

class ContactComponent extends Component
{

    public $name;
    public $email;
    public $phone;
    public $message;

   
    public function render()
    {
        $setting=Setting::find(1);
        return view('livewire.contact-component',['setting'=>$setting])->layout('layouts.guest');
    }

    public function sendMessage(){
        $this->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'message'=>'required',

        ]);
        $contact=new Contact();
        $contact->name=$this->name;
        $contact->email=$this->email;
        $contact->phone=$this->phone;
        $contact->message=$this->message;
        $contact->save();
        Session()->flash('message','Thanks,Your message has been sent successfully!');
        $this-> name="";
        $this-> email="";
        $this-> phone="";
        $this-> message="";
    }
}
