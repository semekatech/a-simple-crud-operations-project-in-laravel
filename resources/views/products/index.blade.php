@extends('layouts.master')
@section('content')
<style>
    .delete-link {
    color: red; 
    cursor: pointer;
    margin-right: 5px;
    transition: color 0.3s ease;
}
.edit-link{
    color: #007bff;
    cursor: pointer;
    margin-right: 5px;
    transition: color 0.3s ease;
}
.edit-link:hover, .delete-link:hover {
    color: #0056b3; 
}
    </style>


    <div class="container-fluid">
        <div class="container">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Products List</h1>
            </div>
            <div class="row mt-2">
                <div class="col-12" style="overflow: auto">
                    <table class="table" id="productTable" style="border-radius: 8px; -moz-border-radius: 6px;">
                        <thead>
                            <tr>
                                <th class="text-center">Sr #</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Batch No</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Pur Date</th>
                                <th class="text-center">Pur Price</th>
                                <th class="text-center">Sale Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <!-- Edit Modal -->
<div class="modal" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="form-group">
                        <label for="editProductName">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="product_name">
                    </div>
                    <div class="form-group">
                        <label for="editBatchNo">Batch No</label>
                        <input type="text" class="form-control" id="editBatchNo" name="batch_no">
                    </div>
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <select name="category" class="form-control" id="editCategory">
                            <option value="">--Select--</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Snacks">Snacks</option>
                            <option value="Wears">Wears</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editUnit">Unit</label>
                        <select name="unit" class="form-control" id="editUnit">
                            <option value="">--Select--</option>
                            <option value="Kilogram">Kilogram</option>
                            <option value="Boxes">Boxes</option>
                            <option value="Bottles">Bottles</option>
                            <option value="Cups">Cups</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPurDate">Pur Date</label>
                        <input type="date" class="form-control" id="editPurDate" name="p_date">
                    </div>
                    <div class="form-group">
                        <label for="editPurPrice">Pur Price</label>
                        <input type="number" class="form-control" id="editPurPrice" name="p_price">
                    </div>
                    <div class="form-group">
                        <label for="editSalePrice">Sale Price</label>
                        <input type="number" class="form-control" id="editSalePrice" name="sale_price">
                    </div>
                    <input type="hidden" id="editProductId" name="id">
                    <button type="submit" class="btn btn-primary" style="background:dodgerblue">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
  <!-- Delete Confirmation Modal -->
  <div class="modal" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  style="background:dodgerblue;border:none" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" style="background:red;border:none" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fetch and display products
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "{{ route('get-products') }}",
                success: function (response) {
                    if (response) {
                        var products = response.products;
                        for (var i = 0; i < products.length; i++) {
                            var product = products[i];
                            var row = '<tr>' +
                                '<td class="text-center">' + (i + 1) + '</td>' +
                                '<td class="text-center">' + product.product_name + '</td>' +
                                '<td class="text-center">' + product.batch_no + '</td>' +
                                '<td class="text-center">' + product.category + '</td>' +
                                '<td class="text-center">' + product.unit + '</td>' +
                                '<td class="text-center">' + product.p_date + '</td>' +
                                '<td class="text-center">' + product.p_price + '</td>' +
                                '<td class="text-center">' + product.sale_price + '</td>' +
                                '<td class="text-center">' +
                                    '<a href="#" class="edit-link" data-id="' + product.id + '">Edit</a> | ' +
                                    '<a href="#" class="delete-link" data-id="' + product.id + '">Delete</a>' +
                                '</td>' +
                                '</tr>';
                            $("#productTableBody").append(row);
                        }
                    }
                },
                error: function (error) {
                    console.error(error);
             
                }
            });

            // Edit Function
            $('#productTableBody').on('click', '.edit-link', function () {
                var productId = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-product-details') }}",
                    data: { id: productId },
                    success: function (response) {
                        if (response) {
                            var product = response.product;

                            // Populate the edit modal with product details
                            $('#editProductId').val(product.id);
                            $('#editProductName').val(product.product_name);
                            $('#editBatchNo').val(product.batch_no);
                            $('#editCategory').val(product.category);
                            $('#editUnit').val(product.unit);
                            $('#editPurDate').val(product.p_date);
                            $('#editPurPrice').val(product.p_price);
                            $('#editSalePrice').val(product.sale_price);
                            // Show the edit modal
                            $('#editModal').modal('show');
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

            // Delete Action
            $('#productTableBody').on('click', '.delete-link', function () {
                var productId = $(this).data('id');
                $('#confirmDelete').data('id', productId);
                // Show the delete confirmation modal
                $('#deleteModal').modal('show');
            });

            // Confirm delete
            $('#confirmDelete').click(function () {
                var productId = $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('delete-product') }}",
                    data: { id: productId },
                    success: function (response) {
                        toastr.success(response.message, 'Success');
                        $('#deleteModal').modal('hide');
                        location.reload();
                    },
                    error: function (error) {
                        toastr.error('Error deleting product', 'Error');
                        $('#deleteModal').modal('hide');
                    }
                });
            });
            // Handle form submission for editing
            $('#editForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "PUT",
                    url: "{{ route('update-product') }}", 
                    data: $('#editForm').serialize(),
                    success: function (response) {
                        // Show a success toast
                        toastr.success(response.message, 'Success');
                        location.reload();
                        $('#editModal').modal('hide');
                    },
                    error: function (error) {
                        toastr.error('Error updating product', 'Error');
                    }
                });
            });
        });
    </script>
@endsection