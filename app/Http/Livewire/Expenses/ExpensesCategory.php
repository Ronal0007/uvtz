<?php

namespace App\Http\Livewire\Expenses;

use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ExpensesCategory extends Component
{
    public $inputs = [];
    public $showEditModal = false;
    public $_inv_category;
    public $categoryIdBeingRemoved = null;

    public function addExpensesCategory(){
        $this->showEditModal = false;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function createExpCategory(){
        $validatedData = Validator::make($this->inputs, [
            'category_name' => 'required|unique:expenses_categories',
            'category_description' => 'required'
        ])->validate();
        $validatedData['status'] = true;
        $validatedData['created_by'] = Auth()->user()->name;
        if (\App\Models\ExpensesCategory::create($validatedData)){
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Inventory Category created Successfully']);
        }else{
            $this->dispatchBrowserEvent('fail',['message' => 'Fail to create Inventory Category']);
        }
    }
    public function editExpCategory(\App\Models\ExpensesCategory $category){
        $this->showEditModal = true;
        $this->_inv_category = $category;
        $this->inputs = $category->toArray();
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateExpCategory(){
        $validatedData = Validator::make($this->inputs, [
            'category_name' => 'required',
            'category_description' => 'required',
        ])->validate();
        $validatedData['created_by'] = Auth()->user()->name;
        if ($this->_inv_category->update($validatedData)){
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Inventory Category Updated Successfully']);
        }else{
            $this->dispatchBrowserEvent('fail',['message' => 'Fail to Update Inventory Category']);
        }
    }
    public function expCategoryIdToDelete($categoryId){
        $this->categoryIdBeingRemoved = $categoryId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function deleteInvCategory(){
        $invCategory = \App\Models\ExpensesCategory::findorFail($this->categoryIdBeingRemoved);
        if($invCategory->delete()){
            $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Inventory Category deleted successfully!']);
        }else{
            $this->dispatchBrowserEvent('fail', ['message' => 'Failed to delete category!']);
        }

    }
    public function render()
    {
        $expCategory = \App\Models\ExpensesCategory::
            orderBy('expenses_categories.category_name')
            ->paginate(20);
        return view('livewire.expenses.expenses-category', [
            'expCategory' => $expCategory
        ]);
    }
}
