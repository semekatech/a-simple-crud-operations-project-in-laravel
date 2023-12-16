@extends('layouts.master')
@section('content')
<!-- Include jQuery -->

  <div class="container-fluid">
    <div class="container">
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Add Product</h1>
      </div>
      <div class="row mt-2">
        <div class="col-12" style="overflow: auto">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
            </div>
            <div class="card-body">
                <form  enctype="multipart/form-data" id="productForm">
                    @csrf
                    <div class="row">
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="Product_name">Product Name</label>
                          <input class="form-control" id="product_name" type="text" name="product_name" placeholder="" value=""  >
                          <div id="error-message-product_name" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Batch No</label>
                          <input class="form-control" id="batch_no" type="text" name="batch_no" placeholder="" >
                          <div id="error-message-batch_no" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Mass( in Kg)</label>
                          <input class="form-control" id="mass" type="number" name="mass" placeholder="" >
                          <div id="error-message-mass" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Purchase Date</label>
                          <input class="form-control" id="p_date" type="date" name="p_date" placeholder="" >
                          <div id="error-message-purchase_date" style="color: red;"></div>
                        </div>
                      </div>
                    
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Purchase Price</label>
                          <input class="form-control" id="phone" type="text" name="p_price" placeholder=""   >
                          <div id="error-message-p_price" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Sale Price</label>
                          <input class="form-control" id="name" type="text" name="sale_price" placeholder="" >
                          <div id="error-message-sale_price" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label>Product Category</label>
                            <select name="category" class="form-control" style="" >
                                <option value="">--Select--</option>
                                <option>Electronics</option>
                                <option >Snacks</option>
                                <option >Wears</option>
                            </select>
                            <div id="error-message-category" style="color: red;"></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label>Product Unit</label>
                            <select name="unit" class="form-control" style="" >
                                <option value="">--Select--</option>
                                <option >Kilogram</option>
                                <option >Boxes</option>
                                <option >Bottles</option>
                                <option >Cups</option>
                            </select>
                            <div id="error-message-unit" style="color: red;"></div>
                        </div>
                      </div>
                      </div>
                      <div class="mb-3">
                        <button id="submitBtn" class="btn btn-success" >Save</button>
                      </div>
                    
                </form>
            </div>
          </div>
          
          
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function () {
        // Form validation and submission
        $("#submitBtn").click(function (event) {
            event.preventDefault();
            $("#error-message-product_name").text("");
            $("#error-message-batch_no").text("");
            $("#error-message-mass").text("");
            $("#error-message-purchase_date").text("");
            $("#error-message-p_price").text("");
            $("#error-message-sale_price").text("");
            $("#error-message-category").text("");
            $("#error-message-unit").text("");

            // product name validation
            var productName = $("#product_name").val();
            if (productName.trim() === "") {
                $("#error-message-product_name").text("Please enter a product name");
                return;
            }

            // batch number validation
            var batchNo = $("#batch_no").val();
            if (batchNo.trim() === "") {
                $("#error-message-batch_no").text("Please enter a batch number");
                return;
            }

            // Mass validation
            var mass = $("#mass").val();
            if (isNaN(mass) || mass <= 0) {
                $("#error-message-mass").text("Please enter a valid mass");
                return;
            }

            // purchase date validation
            var purchaseDate = $("#p_date").val();
            if (purchaseDate.trim() === "") {
                $("#error-message-purchase_date").text("Please enter a purchase date");
                return;
            }

            // purchase price validation
            var purchasePrice = $("#phone").val();
            if (isNaN(purchasePrice) || purchasePrice <= 0) {
                $("#error-message-p_price").text("Please enter a valid purchase price");
                return;
            }

            // sale price validation
            var salePrice = $("#name").val();
            if (isNaN(salePrice) || salePrice <= 0) {
                $("#error-message-sale_price").text("Please enter a valid sale price");
                return;
            }

            // category validation
            var category = $("select[name='category']").val();
            if (category === "") {
                $("#error-message-category").text("Please select a category");
                return;
            }

            //  unit validation
            var unit = $("select[name='unit']").val();
            if (unit === "") {
                $("#error-message-unit").text("Please select a unit");
                return;
            }
            $.ajax({
                type: "POST",
                url: "{{ route('add-product') }}",
                data: $("#productForm").serialize(),
                success: function (response) {
                    // success toast
                    toastr.success('Product added successfully', 'Success');
                    setTimeout(function () {
                        window.location.href = "{{ route('manage-products') }}";
                    }, 2000); 
                  
                },
                error: function (error) {
                    // error toast
                    toastr.error('Error adding product', 'Error');
                }
            });
        });
    });
</script>
@endsection