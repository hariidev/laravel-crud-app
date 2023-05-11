<?php

namespace App\Http\Livewire;
use App\Models\Category as Categories;

use Livewire\Component;

class Category extends Component
{
    public $categories, $name, $description, $category_id;
    public $updateCategory = false;

    protected $listeners = [
        'deleteCategory'=>'destroy'
    ];

    protected $rules = [
        'name'=>'required',
        'description'=>'required'
    ];

    public function store(){
        $this->validate();
        try{
            Categories::create([
                'name'=>$this->name,
                'description'=>$this->description
            ]);
            session()->flash('success','Category Created Successfully!!');
            $this->resetFields();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while creating category!!');
            $this->resetFields();
        }
    }

    public function resetFields() {

        $this->name = "";
        $this->description = "";
    }

    public function render()
    {
        return view('livewire.category');
    }
}
