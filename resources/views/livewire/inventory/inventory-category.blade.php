<div>
    <!-- START: Breadcrumbs-->
    <div class="row">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto"><h4 class="mb-0 text-secondary">Inventory</h4> <p>List of all inventory Category</p></div>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="float-left">
                @can('create_inventory')
                <button wire:click.prevent="addInventoryCategory" class="btn btn-primary"><i class="fa fa-plus"></i> Add Category</button>
                @endcan
            </div>
        </div>
    </div>
    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title text-primary">Available Inventory Category</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-4 float-right">
                        <input type="text" class="form-control col-4 col-sm-12" placeholder="Search......"/>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-centered mb-0" >
                            <thead>
                            <tr>
                                <th> Code</th>
                                <th> Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invCategory as $category)
                                <tr>
                                    <td>{{$category->category_code}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td>
                                        @can('edit_inventory')
                                        <a class="action-icon text-primary" href="" wire:click.prevent="editInvCategory({{$category}})">
                                            <i class="mdi mdi-pen"></i></a>
                                        <a class="action-icon text-danger" href="" wire:click.prevent="invCategoryIdToDelete({{$category->id}})">
                                            <i class="mdi mdi-delete mr-2"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th> Code</th>
                                <th> Name</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!--Add inventory Category Modal -->
            <div class="modal fade" id="form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" >
                    <form wire:submit.prevent="{{ $showEditModal ? 'updateInvCategory' : 'createInvCategory'}}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">
                                    @if ($showEditModal)
                                        <span>Update Inventory Category</span>
                                    @else
                                        <span>Add Inventory Category</span>
                                    @endif
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="username" class="col-form-label">Category Code</label>
                                            <input type="number" wire:model.defer="inputs.category_code" id="name" class="form-control @error('category_code') is-invalid @enderror" placeholder="001" aria-label="name" aria-describedby="basic-addon1">
                                            @error('category_code')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label for="username" class="col-form-label">Category Name</label>
                                            <input type="text" wire:model.defer="inputs.category_name" id="text" class="form-control @error('category_name') is-invalid @enderror" placeholder="Drinks" aria-label="Email" aria-describedby="basic-email">
                                            @error('category_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">
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
            <!--Delete inventory Category Modal -->
            <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Delete Inventory Category</h5>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-danger">Are you sure you want to delete this Inventory Category ?</h5>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal">No</button>
                            <button type="button" wire:click.prevent="deleteInvCategory" class="btn btn-outline-danger">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
</div>

