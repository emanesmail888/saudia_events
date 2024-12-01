<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Subcategory;
use Livewire\WithFileUploads;
use Carbon\Carbon;


class AdminAddCategoryComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $name_ar;
    public $image;
    public $category_id;

    public function render()
    {
        $categories=Category::all();
        return view('livewire.admin.admin-add-category-component',['categories'=>$categories])->layout('layouts.admin');
    }

    public function updated($fields){

        $this->validateOnly($fields,[
            'name'=>'required',
            'name_ar'=>'required',

        ]);

    }
    public function storeCategory(){
        $this->validate([
            'name'=>'required',
            'name_ar'=>'required',

        ]);
        if($this->category_id)
        {
            $scategory=new Subcategory();
            $scategory->name=$this->name;
            $scategory->name_ar=$this->name_ar;
            $scategory->category_id=$this->category_id;
            $imageName="";
            if($this->image){
            $imageName=Carbon::now()->timestamp.'.'.$this->image->getClientOriginalName();
             $this->image->storeAs('categories',$imageName);
            }
            $scategory->image=$imageName;
            $scategory->save();

        }
        else{
        $category=new Category();
        $category->name=$this->name;
        $category->name_ar=$this->name_ar;
        $imageName="";
        if($this->image){
        $imageName=Carbon::now()->timestamp.'.'.$this->image->getClientOriginalName();
        $this->image->storeAs('categories',$imageName);
        }
        $category->image=$imageName;
        $category->save();
        }
        session()->flash('message','Category has been created');
        $this->name="";
        $this->name_ar="";
        $this->image="";

    }

}
