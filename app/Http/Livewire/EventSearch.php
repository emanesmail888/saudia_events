<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Region;
use App\Models\Event;
use Livewire\WithPagination;


class EventSearch extends Component
{
    use WithPagination;


    public $category_id;
    public $region_id;
    protected $events;
    public $search_keyword;
    public $perPage = 6;


    

    public function getEvents()
    {
        return $this->events;
    }


    public function loadMore()
    {
        $this->perPage = $this->perPage +6 ;
        $this->search();
    }

    public function search()
    {
        $query = Event::query();

        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        if ($this->region_id) {
            $query->where('region_id', $this->region_id );
        }

              
        if ($this->search_keyword && $this->region_id && $this->category_id) {
            $query->where('event_name', 'like', '%' . $this->search_keyword . '%')
                ->orWhere('region_id', $this->region_id)
                ->orWhere('category_id', $this->category_id);
        }
            
        

        // $this->events = $query->paginate(12, ['*'], 'page', $this->page);
        $this->events = $query->paginate($this->perPage);




    }
    
    public function render()
    {
        $categories=Category::cursor();
        $regions=Region::cursor();
        return view('livewire.event-search',['categories'=>$categories,
        'regions'=>$regions]);
    }

   
}
