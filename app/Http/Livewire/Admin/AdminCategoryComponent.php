<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;

use Livewire\WithPagination;


class AdminCategoryComponent extends Component
{
    use WithPagination;


    public function deleteCategory($id)
    {
        $category=Category::find($id);
        $category->delete();
        session()->flash('message','Category has been deleted successfully!');

    }
    public function deleteSubcategory($id)
    {
        $scategory=Subcategory::findOrFail($id);
        $scategory->delete();
        session()->flash('message','SubCategory has been deleted Successfully!');


    }

    public function render()
    {
        $categories=Category::cursor();
        return view('livewire.admin.admin-category-component',['categories'=>$categories])->layout('layouts.admin');
    }
}
