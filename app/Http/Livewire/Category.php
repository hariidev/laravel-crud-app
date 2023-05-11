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

    public function edit($id){
        $category = Categories::findOrFail($id);
        $this->name = $category->name;
        $this->description = $category->description;
        $this->category_id = $category->id;
        $this->updateCategory = true;
    }

    public function update() {

         $this->validate();
         try{
             Categories::find($this->category_id)->fill([
                 'name'=>$this->name,
                 'description'=>$this->description
             ])->save();
             session()->flash('success','Category Updated Successfully!!');
     
         }catch(\Exception $e){
             session()->flash('error','Something goes wrong while updating category!!');
         }
    }

    public function cancel() {

        $this->updateCategory = false;
        $this->resetFields();
    }

    public function destroy($id){
        try{
            Categories::find($id)->delete();
            session()->flash('success',"Category Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting category!!");
        }
    }

    public function render()
    {
        $this->categories = Categories::select('id','name','description')->get();
        return view('livewire.category');
    }
}
