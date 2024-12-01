<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Service;

class AdminServiceComponent extends Component
{

    public function render()
    {
        $services=Service::cursor();

        return view('livewire.admin.admin-service-component',['services'=>$services])->layout('layouts.admin');
    }


    public function deleteService($id)
    {
        $service=Service::findOrFail($id);
        $service->delete();
        session()->flash('message','Service has been deleted successfully!');

    }


}
