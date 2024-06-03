<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use Livewire\WithPagination;

class AdminEventComponent extends Component
{
    use WithPagination;

    public function deleteEvent($id)
    {
        $event=Event::findOrFail($id);
        $event->delete();
        session()->flash('message','Event has been deleted successfully!');

    }

    public function render()
    {
        $events=Event::cursor();
        return view('livewire.admin.admin-event-component',['events'=>$events])->layout('layouts.admin');

    }
}
