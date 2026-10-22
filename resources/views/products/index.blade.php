@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Products</h2>
        <p class="text-muted mb-0">Manage your product inventory.</p>
    </div>

    <button class="btn btn-primary" id="createProduct">
        Add Product
    </button>
</div>

<div id="alertContainer"></div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="form-group">
            <input type="text"
                   id="search"
                   class="form-control"
                   placeholder="Search by product name or SKU...">
        </div>

        <div id="productsTable">
            @include('products.partials.table', ['products' => $products])
        </div>
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="productForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="productId">

                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" data-error="name"></div>
                    </div>

                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" required>
                        <div class="invalid-feedback" data-error="sku"></div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description"
                                  name="description" rows="3"></textarea>
                        <div class="invalid-feedback" data-error="description"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price"
                                   name="price" min="0" step="0.01" required>
                            <div class="invalid-feedback" data-error="price"></div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock"
                                   name="stock" min="0" step="1" required>
                            <div class="invalid-feedback" data-error="stock"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveProduct">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal"
     tabindex="-1" role="dialog"
     aria-labelledby="deleteProductModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered"
         role="document">

        <div class="modal-content delete-modal">

            <div class="modal-header border-0 pb-0">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body text-center px-4 pt-0">

                <div class="delete-icon mx-auto mb-3">
                    <i class="fas fa-trash-alt"></i>
                </div>

                <h5 class="font-weight-bold mb-2"
                    id="deleteProductModalLabel">
                    Delete Product
                </h5>

                <p class="text-muted mb-4">
                    Are you sure you want to delete this product?
                </p>

                <div class="product-delete-info text-left mb-4">
                    <small class="text-muted d-block mb-1">
                        PRODUCT NAME
                    </small>

                    <h6 class="font-weight-bold mb-2"
                        id="deleteProductName">
                        Product name
                    </h6>

                    <div class="d-flex align-items-center">
                        <span class="text-muted mr-2">SKU:</span>
                        <span id="deleteProductSku">-</span>
                    </div>
                </div>

                <p class="small text-muted mb-4">
                    This action cannot be undone.
                    The product will be permanently removed.
                </p>

                <div id="deleteProductError"
                     class="alert alert-danger text-left d-none"
                     role="alert">
                </div>

                <div class="d-flex justify-content-center mb-2">
                    <button type="button"
                            class="btn btn-light border mr-2 px-4"
                            data-dismiss="modal"
                            id="cancelDeleteProduct">
                        Cancel
                    </button>

                    <button type="button"
                            class="btn btn-danger px-4"
                            id="confirmDeleteProduct">
                        <i class="fas fa-trash-alt mr-1"></i>
                        Delete Product
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/products.js') }}"></script>
@endpush