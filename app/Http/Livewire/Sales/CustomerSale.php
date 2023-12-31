<?php

namespace App\Http\Livewire\Sales;

use App\Models\SalePayment;
use App\Models\Sales;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerSale extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $customer_id;
    public $showEditModal = false;
    public $search;
    public $paymentMd = [
        'Cash',
        'Bank',
        'Mobile',
    ];

    public function mount($customer_id = null){
        $this->customer_id = $customer_id;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function addPayment($orderId){
        $this->inputs = [];
        $this->orderId = $orderId;
        $sale = Sales::where('id', $this->orderId)->first();
        $this->invNumber = $sale->inv_no;
        $this->balance = $sale->total_amount - $sale->paid_amount;
        $this->dispatchBrowserEvent('show-form');
    }
    public function saveAddPayment(){
        $validatedData = Validator::make($this->inputs, [
            'paid_amount' => 'required|integer',
            'payment_method' => 'required'
        ])->validate();
        $balance = Sales::where('id', $this->orderId)->first();
        $order_mount = $balance->total_amount;
        $paid_amount = $balance->paid_amount;
        $r_balance = $order_mount - $paid_amount;
        $payment_status = 'paid';
        if($r_balance > 0 && $r_balance > $validatedData['paid_amount']){
            $payment_status = 'Partial';
            $paid_amount = $validatedData['paid_amount'];
        }elseif($r_balance > 0 && $r_balance < $validatedData['paid_amount']){
            $payment_status = 'Paid';
            $paid_amount = $r_balance;
        }
        $payment = Sales::find($this->orderId);
        $payment->status = ($order_mount == $paid_amount);
        $payment->paid_amount += $paid_amount;
        $payment->payment_status = $payment_status;
        if ($payment->save()){
            $paymentTbl = new SalePayment();
            $paymentTbl->status = true;
            $paymentTbl->sale_id = $this->orderId;
            $paymentTbl->date = $this->inputs['date'];
            $paymentTbl->created_by = Auth::user()->name;
            $paymentTbl->amount = $validatedData['paid_amount'];
            $paymentTbl->payment_method = $validatedData['payment_method'];
            if($paymentTbl->save()){
                $this->dispatchBrowserEvent('hide-form', ['message' => 'Payment was successfully processed']);
            }else{
                $this->dispatchBrowserEvent('fail', ['message' => 'Fail to Processed Payment']);
            }
        }else{
            $this->dispatchBrowserEvent('fail', ['message' => 'Fail to Processed Payment']);
        }
    }
    public function markPaid($orderId){
        $this->inputs = [];
        $this->orderId = $orderId;
        $sale = Sales::where('id', $this->orderId)->first();
        $this->invNumber = $sale->inv_no;
        $this->balance = $sale->total_amount - $sale->paid_amount;
        $this->dispatchBrowserEvent('show-form1');
    }
    public function saveMarkPaid(){
        $validatedData = Validator::make($this->inputs, [
            'payment_method' => 'required'
        ])->validate();
        $balance = Sales::where('id', $this->orderId)->first();
        $order_mount = $balance->total_amount;
        $paid_amount = $balance->paid_amount;
        $r_balance = $order_mount - $paid_amount;
        $payment = Sales::find($this->orderId);
        $payment->status = ($order_mount == $paid_amount);
        $payment->paid_amount += $r_balance;
        $payment->payment_status = 'Paid';
        if ($payment->save()){
            $paymentTbl = new SalePayment();
            $paymentTbl->status = true;
            $paymentTbl->sale_id = $this->orderId;
            $paymentTbl->date = $this->inputs['date'];
            $paymentTbl->created_by = Auth::user()->name;
            $paymentTbl->amount = $r_balance;
            $paymentTbl->payment_method = $validatedData['payment_method'];
            if($paymentTbl->save()){
                $this->dispatchBrowserEvent('hide-form1', ['message' => 'Payment was successfully processed']);
            }else{
                $this->dispatchBrowserEvent('fail', ['message' => 'Fail to Processed Payment']);
            }
        }
    }
    public function cancelOrder($orderId){
        $this->inputs = [];
        $this->orderId = $orderId;
        $sale = Sales::where('id', $this->orderId)->first();
        $this->invNumber = $sale->inv_no;
        $this->dispatchBrowserEvent('show-delete-modal');
    }

    public function render()
    {
        $search = '%'.$this->search.'%';
        $customerSales = Sales::
            join('customers','customers.id','sales.customer_id')
            ->select('sales.*','customers.customer_name')
            ->where(function($query) use ($search){
                $query->where('sales.inv_no','LIKE',$search);
            })
            ->where('customers.id',decrypt($this->customer_id))
            ->paginate();

        $customer = Sales::
            join('customers','customers.id','sales.customer_id')
            ->select('sales.*','customers.customer_name')
            ->where('customers.id',decrypt($this->customer_id))
            ->first();

        $payStatus = Sales::where('customer_id',decrypt($this->customer_id))
            ->groupBy('payment_status')
            ->select( DB::raw('payment_status , COUNT(*) as status_count') )
            ->get();
        return view('livewire.sales.customer-sale',[
            'customer'  => $customer,
            'payStatus'  => $payStatus,
            'customerSales'  => $customerSales
        ]);
    }
}
