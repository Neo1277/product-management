$(function () {
    const baseUrl = '/products';
    let searchTimer;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    function showMessage(message, type = 'success') {
        $('#alertContainer').html(
            $('<div>')
                .addClass(`alert alert-${type} alert-dismissible fade show`)
                .attr('role', 'alert')
                .append(document.createTextNode(message))
                .append(
                    $('<button>')
                        .attr({
                            type: 'button',
                            'data-dismiss': 'alert',
                            'aria-label': 'Close'
                        })
                        .addClass('close')
                        .append($('<span>').attr('aria-hidden', 'true').text('×'))
                )
        );
    }

    function resetForm() {
        $('#productForm')[0].reset();
        $('#productId').val('');
        $('#productForm .is-invalid').removeClass('is-invalid');
        $('[data-error]').text('');
        $('#modalTitle').text('Add Product');
        $('#saveProduct').prop('disabled', false).text('Save Product');
    }

    function displayErrors(errors) {
        $('#productForm .is-invalid').removeClass('is-invalid');
        $('[data-error]').text('');

        $.each(errors, function (field, messages) {
            const input = $(`[name="${field}"]`);

            input.addClass('is-invalid');
            $(`[data-error="${field}"]`).text(messages[0]);
        });
    }

    function loadProducts(url = baseUrl) {
        $.get(url, { search: $('#search').val() })
            .done(function (response) {
                $('#productsTable').html(response.html);
                $('#pagination').html(response.pagination);
            })
            .fail(function () {
                showMessage('Unable to load products.', 'danger');
            });
    }

    $('#createProduct').on('click', function () {
        resetForm();
        $('#productModal').modal('show');
    });

    $('#search').on('input', function () {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(function () {
            loadProducts();
        }, 300);
    });

    $('#productsTable').on('click', '.pagination a', function (event) {
        event.preventDefault();

        const url = new URL($(this).attr('href'), window.location.origin);
        loadProducts(url.pathname + url.search);
    });

    $('#productsTable').on('click', '.editProduct', function () {
        const id = $(this).data('id');

        $.get(`${baseUrl}/${id}`)
            .done(function (product) {
                resetForm();

                $('#productId').val(product.id);
                $('#name').val(product.name);
                $('#sku').val(product.sku);
                $('#description').val(product.description);
                $('#price').val(product.price);
                $('#stock').val(product.stock);
                $('#is_active').val(product.is_active ? '1' : '0');

                $('#modalTitle').text('Edit Product');
                $('#productModal').modal('show');
            })
            .fail(function () {
                showMessage('Unable to load the selected product.', 'danger');
            });
    });

    $('#productForm').on('submit', function (event) {
        event.preventDefault();

        const id = $('#productId').val();
        const isEditing = Boolean(id);
        const url = isEditing ? `${baseUrl}/${id}` : baseUrl;

        const data = $(this).serializeArray();

        if (isEditing) {
            data.push({ name: '_method', value: 'PUT' });
        }

        $('#saveProduct').prop('disabled', true).text('Saving...');

        $.ajax({
            url: url,
            method: 'POST',
            data: $.param(data)
        })
        .done(function (response) {
            $('#productModal').modal('hide');
            showMessage(response.message);
            loadProducts();
        })
        .fail(function (xhr) {
            if (xhr.status === 422) {
                displayErrors(xhr.responseJSON.errors);
                return;
            }

            showMessage(
                xhr.responseJSON?.message || 'An unexpected error occurred.',
                'danger'
            );
        })
        .always(function () {
            $('#saveProduct').prop('disabled', false).text('Save Product');
        });
    });

    $('#productModal').on('hidden.bs.modal', resetForm);


    let productToDelete = null;

    // Open the delete confirmation modal
    $('#productsTable').on('click', '.deleteProduct', function () {
        const button = $(this);

        productToDelete = button.data('id');

        $('#deleteProductName').text(button.data('name'));
        $('#deleteProductSku').text(button.data('sku'));

        $('#deleteProductError')
            .addClass('d-none')
            .text('');

        $('#confirmDeleteProduct')
            .prop('disabled', false)
            .html('<i class="fas fa-trash-alt mr-1"></i> Delete Product');

        $('#deleteProductModal').modal('show');
    });

    // Confirm product deletion
    $('#confirmDeleteProduct').on('click', function () {
        if (!productToDelete) {
            return;
        }

        const productId = productToDelete;
        const button = $(this);

        button
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm mr-2"></span> Deleting...');

        $('#deleteProductError')
            .addClass('d-none')
            .text('');

        $.ajax({
            url: `/products/${productId}`,
            method: 'POST',
            data: {
                _method: 'DELETE'
            }
        })
        .done(function (response) {
            $('#deleteProductModal').modal('hide');

            showMessage(
                response.message || 'Product deleted successfully.',
                'success'
            );

            loadProducts();
        })
        .fail(function (xhr) {
            const message =
                xhr.responseJSON?.message ||
                'Unable to delete the product. Please try again.';

            $('#deleteProductError')
                .removeClass('d-none')
                .text(message);
        })
        .always(function () {
            button
                .prop('disabled', false)
                .html('<i class="fas fa-trash-alt mr-1"></i> Delete Product');
        });
    });

    // Clear the selected product when the modal closes
    $('#deleteProductModal').on('hidden.bs.modal', function () {
        productToDelete = null;

        $('#deleteProductError')
            .addClass('d-none')
            .text('');
    });

});