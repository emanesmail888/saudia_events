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
        $category=Category::where('id',$this->category_id)->first();
        $category_id=$category->id;
        $category_name=$category->name;
        $category_name_ar=$category->name_ar;

        $events=Event::where('category_id',$this->category_id)
        ->orWhere('event_name', 'LIKE', '%' . $category_name . '%')
        ->paginate(15);
       

        return view('livewire.category-component',['events'=>$events,'category_name'=>$category_name,'category_name_ar'=>$category_name_ar])->layout('layouts.home');
    }
  
   


}
