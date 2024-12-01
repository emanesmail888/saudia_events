<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;

class AdminEditCategoryComponent extends Component
{

    use WithFileUploads;
    public $category_id;
    public $name;
    public $name_ar;
    public $image;
    public $newImage;
    public $scategory_id;
    
    public function render()
    {
        $categories=Category::all();

        return view('livewire.admin.admin-edit-category-component',['categories'=>$categories])->layout('layouts.admin');
    }





    public function mount($category_id,$scategory_id=null){
        if($scategory_id)
        {
        $scategory=Subcategory::where('id',$scategory_id)->firstOrFail();
        $this->scategory_id=$scategory->id;
        $this->category_id=$scategory->category_id;
        $this->name=$scategory->name;
        $this->name_ar=$scategory->name_ar;
        $this->image=$scategory->image;


        }
        else{
        $category=Category::where('id',$category_id)->firstOrFail();
        $this->category_id=$category->id;
        $this->name=$category->name;
        $this->name_ar=$category->name_ar;
        $this->image=$category->image;
        }

    }


    public function updated($fields){

        $this->validateOnly($fields,[
            'name'=>'required',
            'name_ar'=>'required',

        ]);

    }
    public function updateCategory(){
        $this->validate([
            'name'=>'required',
            'name_ar'=>'required',

        ]);
        if($this->scategory_id)
        {
            $scategory=Subcategory::findOrFail($this->scategory_id);
            $scategory->name=$this->name;
            $scategory->name_ar=$this->name_ar;
            $scategory->category_id=$this->category_id;
            if($this->newImage)
            {
                $imageName=Carbon::now()->timestamp.'.'.$this->newImage->getClientOriginalName();
                $this->newImage->storeAs('categories',$imageName);
                $scategory->image=$imageName;
             }

            $scategory->save();

        }
        else{


        $category=Category::findOrFail($this->category_id);
        $category->name=$this->name;
        $category->name_ar=$this->name_ar;
        if($this->newImage)
            {
                $imageName=Carbon::now()->timestamp.'.'.$this->newImage->getClientOriginalName();
                $this->newImage->storeAs('categories',$imageName);
                $category->image=$imageName;
             }

        $category->save();
            }
        session()->flash('message','Category has been updated');
        $this->name="";
        $this->name_ar="";
        $this->image="";
    }




}


