@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Add Product | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Add product
@endsection

{{-- page content --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Product Information</h4>

            @include('admin.alert')

            <form action="{{ route('brands.index') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
                id="productForm" novalidate>
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Product Name"
                                name="name" value="{{ old('name') }}" required>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" name="brand" id="brand">
                                <option selected disabled value="">Choose...</option>

                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" value=""
                                        placeholder="Price" min="0" step="0.01" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="comparePrice" class="form-label">Comapre Price</label>
                                    <input type="number" class="form-control" name="compare_price" id="comparePrice"
                                        value="" placeholder="Compare Price" min="0" step="0.01">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <div id="editor" style="height:250px;"></div>
                            <input name="description" id="description" class="form-control" style="display:none;"
                                required></input>
                            <p class="error"></p>
                        </div>

                        <h4 class="header-title mb-3">Inventory Management</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU (Stock Keeping Unit)<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sku" id="sku" value=""
                                        placeholder="sku" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Barcode</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode" value=""
                                        placeholder="Barcode">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-2 form-check-primary">
                            <input type="hidden" name="track_quantity" value="No">
                            <input class="form-check-input rounded" type="checkbox" name="track_quantity" value="Yes"
                                id="track_quantity" checked>
                            <label class="form-check-label" for="track_quantity">Track Quantity</label>
                        </div>

                        <div class="mb-3">
                            <input type="number" class="form-control" name="quantity" id="quantity" value=""
                                min="0" placeholder="Quantity">
                            <p class="error"></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="status1" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status1" required>
                                {{-- <option selected disabled value="">Choose...</option> --}}
                                <option selected value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="featured" class="form-label">Featured</label>
                            <select class="form-select" name="is_featured" id="featured" required>
                                {{-- <option selected disabled value="">Choose...</option> --}}
                                <option selected value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="validationCustom03" class="form-label">Category<span
                                    class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" id="category" required>
                                <option selected disabled value="">Choose...</option>
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="subCategory" class="form-label">Sub Category</label>
                            <select class="form-select" name="subCategory" id="subCategory">
                                <option selected disabled value="">Choose...</option>
                            </select>
                            <p class="error"></p>
                        </div>

                        {{-- product image --}}
                        <div class="mb-3">
                            <label class="form-label" for="image">Product Image<span
                                    class="text-danger">*</span></label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <i class="fe-upload-cloud fs-1"></i>
                                    <h4>Click to upload product image</h4>
                                </div>
                            </div>
                            <p class="error"></p>
                            <div id="upload-img" class="d-flex flex-column mt-2 gap-2">

                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" name="submit">Add Product</button>
                <a href="{{ route('products.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>

@endsection

@section('customJs')
    <script>
        // for getting sb category
        $('#category').change(function() {
            let category_id = $(this).val();

            $.ajax({
                url: "{{ route('product.subCategory') }}",
                type: 'get',
                data: {
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $('#subCategory').find("option").not(":first").remove();
                    $.each(response["subCategories"],
                        function(key, item) {
                            $('#subCategory').append(
                                `<option value='${item.id}'>${item.name}</option>`);
                        });
                },
                error: function() {
                    console.log("something wrong");
                }
            })
        });

        //image upload

        // for submitting form
        $('#productForm').submit(function(event) {
            event.preventDefault();
            let formArray = $(this).serializeArray();
            $('button[type="submit"]').prop('disable', true);

            $.ajax({
                url: "{{ route('products.store') }}",
                type: 'post',
                data: formArray,
                dataType: 'json',
                success: function(response) {
                    if (response['status'] == true) {
                        location.reload();
                    } else {
                        let errors = response['errors'];

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select").removeClass('is-invalid');

                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid').siblings('p')
                                .addClass('invalid-feedback').html(value);
                        })
                    }
                },
                error: function() {
                    console.log("something wrong");
                }
            })
        });


        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            // init: function() {
            //     this.on('addedfile', function(file) {
            //         if (this.files.length > 1) {
            //             this.removeFile(this.files[0])
            //         }
            //     });
            // },
            url: "{{ route('tempImages.create') }}",
            maxFiles: 5,
            paramName: 'image',
            addRemoveLinks: true,
            required: true,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                // $("$image_id").val(response.image_id);

                let html = `
                             <div id="image${response.image_id}" class="uploaded-img d-flex align-items-center justify-content-between rounded border p-2">
                                <input type="text" name="images[]" value="${response.image_id}" hidden>
                                 <img class="rounded" src="${response.imagePath}"
                                 alt="Image Preview" style="height: 60px;">
                                 <a href="javascript:void(0);" onclick="deleteImage(${response.image_id})">
                                    <i class="fe-x"></i>
                                 </a>
                            </div>
                            `;
                $("#upload-img").append(html);
            },
            complete: function(file) {
                this.removeFile(file);
            }
        });

        function deleteImage(id) {
            $("#image" + id).remove();
        }
    </script>
@endsection
