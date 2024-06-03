<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Event;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $category_id;

    public function mount($category_id)
    {
  
     $this->category_id=$category_id ;
    }

    public function render()
    {
        
        $events=Event::where('category_id',$this->category_id)->paginate(15);
        $category=Category::where('id',$this->category_id)->first();
        $category_id=$category->id;
        $category_name=$category->name;

        return view('livewire.category-component',['events'=>$events,'category_name'=>$category_name])->layout('layouts.home');
    }
  
   


}
