<div class="table-responsive">
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>${{ number_format((float) $product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge badge-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="text-right text-nowrap">
                        <button class="btn btn-sm btn-outline-primary editProduct"
                                data-id="{{ $product->id }}">
                            Edit
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger deleteProduct"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-sku="{{ $product->sku }}">
                            <i class="fas fa-trash-alt mr-1"></i>
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No products found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="pagination">
    {{ $products->links() }}
</div>