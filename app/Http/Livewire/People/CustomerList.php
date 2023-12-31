<?php

namespace App\Http\Livewire\People;

use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $inputs = [];
    public $showEditModal = false;
    public $_customer;
    public $search;
    public $customerIdBeingRemoved = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addCustomer(){
        $this->showEditModal = false;
        $this->inputs = [];
        $this->dispatchBrowserEvent('show-form');
    }

    public function createCustomer(){
        $validatedData = Validator::make($this->inputs, [
            'customer_name' => 'required',
            'customer_phone' => 'required|unique:customers',
            'customer_city' => 'required',
            'customer_address' => 'required'
        ])->validate();
        $validatedData['status'] = true;
        $validatedData['created_by'] = Auth()->user()->name;
        if (Customer::create($validatedData)){
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Customer created Successfully']);
        }else{
            $this->dispatchBrowserEvent('fail',['message' => 'Fail to create Customer']);
        }
    }
    public function editCustomer(Customer $customer){
        $this->showEditModal = true;
        $this->_customer = $customer;
        $this->inputs = $customer->toArray();
        $this->dispatchBrowserEvent('show-form');
    }
    public function updateCustomer(){
        $validatedData = Validator::make($this->inputs, [
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_city' => 'required',
            'customer_address' => 'required'
        ])->validate();
        $validatedData['created_by'] = Auth()->user()->name;
        if ($this->_customer->update($validatedData)){
            $this->dispatchBrowserEvent('hide-form', ['message' => 'Customer Updated Successfully']);
        }else{
            $this->dispatchBrowserEvent('fail',['message' => 'Fail to Update Customer']);
        }
    }
    public function customerIdToDelete($customerId){
        $this->customerIdBeingRemoved = $customerId;
        $this->dispatchBrowserEvent('show-delete-modal');
    }
    public function deleteCustomer(){
        $invCategory = Customer::findorFail($this->customerIdBeingRemoved);
        $invCategory->delete();
        $this->dispatchBrowserEvent('hide-delete-modal', ['message' => 'Customer deleted successfully!']);

    }
    public function render()
    {
        $search= '%'.$this->search.'%';
        $customers = Customer::
            leftJoin('customer_details', 'customer_details.customer_id', 'customers.id')
            ->where(function($query) use ($search){
                $query->where('customer_phone','LIKE',$search);
                $query->orWhere('customer_city','LIKE',$search);
                $query->orWhere('customer_name','LIKE',$search);
            })
            ->select('customers.*', )
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.people.customer-list', [
            'customers' => $customers
        ]);
    }
}
