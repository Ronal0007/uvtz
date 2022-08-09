<div>
    <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0 text-secondary">Inventory</h4><p>Products available in Inventory </p></div>
                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item active">Products</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="row">
        <div class="col-12  col-md-6 col-lg-3 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                        <i class="fas fa-user icons card-liner-icon mt-2 text-success"></i>
                        <div class='card-liner-content'>
                            {{--<h2 class="card-liner-title text-success">{{$req_emp}}</h2>--}}
                            <h6 class="card-liner-subtitle">Required Employee</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12  col-md-6 col-lg-3 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                        <i class="fas fa-users icons card-liner-icon mt-2 text-info"></i>
                        <div class='card-liner-content'>
                            {{--<h2 class="card-liner-title text-info">{{$avail_emp}}</h2>--}}
                            <h6 class="card-liner-subtitle">Availbe Employee</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12  col-md-6 col-lg-3 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                        <i class="fas fa-users icons card-liner-icon mt-2 text-secondary"></i>
                        <div class='card-liner-content'>
                            {{--<h2 class="card-liner-title text-secondary">{{$suspended_emp}} | Tsh: {{number_format($suspended_salary)}}</h2>--}}
                            <h6 class="card-liner-subtitle">Suspended Employee</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12  col-md-6 col-lg-3 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class='d-flex px-0 px-lg-2 py-2 align-self-center'>
                        <i class="fab fa-cc-visa card-liner-icon mt-2 text-danger"></i>
                        <div class='card-liner-content'>
                            {{--<h2 class="card-liner-title text-danger">Tsh: {{number_format($sum_sal)}}</h2>--}}
                            <h6 class="card-liner-subtitle">Total Salary</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- START: Card Data-->
    <div class="row mt-3">
        <div class="col-md-12">
            <button wire:click.prevent="addNewProduct" class="btn btn-primary mb-2"><i class="fa fa-plus"></i> Add Product</button>
        </div>
    </div>
    <!-- START: Card Data-->
    <div class="row mt-1">
        <div class="col-md-12 col-lg-12 mt-12">
            <div class="card border-bottom-0">
                <div class="card-content border-bottom border-info border-w-5">
                    <div class="card-body">
                        <nav>
                            <div class="nav nav-tabs font-weight-bold border-bottom" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-employee-tab" data-toggle="tab" href="#nav-employee" role="tab" aria-controls="nav-home" aria-selected="true">Employee</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-employee" role="tabpanel" aria-labelledby="nav-employee-tab">
                                <div class="col-12 mt-2">
                                    <div class="justify-content-between align-items-center">
                                        <div class="float-left justify-content-end">
                                            <input type="text"  class="form-control col-sm-12" placeholder="Search.....">
                                        </div>
                                        <div class="btn-group float-right justify-content-end">
                                            <button wire:click.prevent="exportExcel" class="btn btn-outline-primary mb-2"><i class="fas fa-file-download"></i> Excel</button>
                                            <button wire:click.prevent="" class="btn btn-outline-primary mb-2"><i class="fas fa-file-download"></i> Pdf</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="" class="display table" >
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Code</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Category Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td><a style="color: #4c75f2" href="{{ route('inventory.details', ['product_id' => \encrypt($product->id)]) }}">{{$product->product_name}}</a></td>
                                                    <td>{{$product->product_code}}</td>
                                                    <td>Tsh {{number_format($product->product_price)}}</td>
                                                    <td>{{number_format($product->product_quantity)}} {{$product->product_unit}}</td>
                                                    <td><a style="color: #4c75f2" href="">{{$product->category_name}}</a></td>
                                                    <td>
                                                        @if ($product->status == 1) <span wire:click.prevent="empStatusModal({{$product}})" style="cursor: pointer;" class="badge outline-badge-primary">Available</span>@endif
                                                        @if ($product->status == 0) <span wire:click.prevent="empStatusModal({{$product}})" style="cursor: pointer;" class="badge outline-badge-warning">Not Available</span> @endif
                                                    </td>
                                                    <td>
                                                        <a class="line-h-1 h6 text-primary" href="" wire:click.prevent="editProduct({{$product}})">
                                                            <i class="fas fa-edit mr-2"></i></a>
{{--                                                        <a class="line-h-1 h6 text-danger" href="" wire:click.prevent="empStatusModal({{$product}})">--}}
{{--                                                            <i class="fas fa-sign-out-alt mr-2"></i></a>--}}
                                                        <a class="line-h-1 h6 text-danger" href="" wire:click.prevent="addProduct({{$product->id}})">
                                                            <i class="fas fa-plus mr-2"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Product Code</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Category Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <di class="d-flex justify-content-end">
                                        {{ $products->links() }}
                                    </di>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Add New Employee Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <form wire:submit.prevent="{{ $showEditModal ? 'updateProduct' : 'createProduct'}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            @if ($showEditModal)
                                <span>Update Product</span>
                            @else
                                <span>Add New Product</span>
                            @endif
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hta_id">Product Name</label>
                                <input type="text" wire:model="inputs.product_name" class="form-control @error('product_name') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dpt_id">Product Code</label>
                                <input type="text" wire:model.defer="inputs.product_code" class="form-control @error('product_code') is-invalid @enderror"/>
                                @error('product_code')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dpt_id">Category</label>
                                <select  wire:model.defer="inputs.category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option selected >Choose Category</option>
                                    @foreach($prodCategory as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Cost</label>
                                <input type="number" wire:model.defer="inputs.product_cost" class="form-control @error('product_cost') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_cost')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Sell Price</label>
                                <input type="number" wire:model.defer="inputs.product_price" class="form-control @error('product_price') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_price')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Quantity</label>
                                <input type="number" wire:model.defer="inputs.product_quantity" class="form-control @error('product_quantity') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_quantity')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Alert Quantity</label>
                                <input type="number" wire:model.defer="inputs.product_stock_alert" class="form-control @error('product_stock_alert') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_stock_alert')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">SI Unit</label>
                                <input type="text" wire:model.defer="inputs.product_unit" class="form-control @error('product_unit') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_unit')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Tax (%)</label>
                                <input type="number" wire:model.defer="inputs.product_order_tax" class="form-control @error('product_order_tax') is-invalid @enderror" aria-label="name" aria-describedby="basic-addon1">
                                @error('product_order_tax')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="no_of_emp">Tax type</label>
                                <select wire:model.defer="inputs.product_tax_type" class="form-control @error('product_tax_type') is-invalid @enderror">
                                    <option selected> Choose Tax type</option>
                                    <option value="">Inclusive</option>
                                    <option value="">Exclusive</option>
                                </select>
                                @error('product_tax_type')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="all_type">Note</label>
                                <textarea wire:model.defer="inputs.product_note" cols="30" rows="3" class="form-control @error('product_note') is-invalid @enderror"></textarea>
                                @error('product_note')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn float-right btn-primary">
                            @if ($showEditModal)
                                <span>Save Changes</span>
                            @else
                                <span>Save</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Change Employee Status Modal -->
    <div class="modal fade" id="form1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="changeEmpStatus">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            <span>Change Employee Status</span>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status_id">Status</label>
                            <select wire:model.defer="inputs.status" class="form-control @error('status') is-invalid @enderror">
                                <option value="" selected>Select Status</option>
                                {{--@foreach ($empsatatus as $key => $status)--}}
                                    {{--<option value="{{$key}}">{{$status}}</option>--}}
                                {{--@endforeach--}}
                            </select>
                            @error('status')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="hta_id">Description</label>
                            <textarea wire:model="inputs.desc" cols="10" rows="5" class="form-control @error('desc') is-invalid @enderror" placeholder="This employee has done ..."></textarea>
                            @error('desc')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Increase Product quantity Modal -->
    <div class="modal fade" id="form2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="addProductQty">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            <span class="text-secondary">Increase Product Quantity</span>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status_id">Quantity</label>
                            <input wire:model.defer="inputs.product_quantity" class="form-control @error('product_quantity') is-invalid @enderror"/>
                            @error('product_quantity')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span>Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Delete User Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Delete User</h5>
                </div>
                <div class="modal-body">
                    <h5 class="text-danger">Are you sure you want to delete this Position ?</h5>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-outline-success" data-dismiss="modal">No</button>
                    <button type="button" wire:click.prevent="deletePosition" class="btn btn-outline-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>