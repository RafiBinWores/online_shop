@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Edit Product | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Edit product
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
                @method('put')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" placeholder="Product Name"
                                name="name" value="{{ $product->name }}" required>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" name="brand" id="brand">
                                <option selected disabled value="">Choose...</option>

                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <option {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                            value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price"
                                        value="{{ $product->price }}" placeholder="Price" min="0" step="0.01"
                                        required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="comparePrice" class="form-label">Compare Price</label>
                                    <input type="number" class="form-control" name="compare_price" id="comparePrice"
                                        value="{{ $product->compare_price }}" placeholder="Compare Price" min="0"
                                        step="0.01">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <p class="mb-3">Enter the original price in the compare price field and a lower price in the
                                pricing field to
                                show the discounted price. </p>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <div id="editor" style="height:250px;">
                                {{ strip_tags($product->description) }}
                            </div>

                            <textarea name="description" id="description" class="form-control" style="display:none;" required>{{ strip_tags($product->description) }}</textarea>

                            <p class="error"></p>
                        </div>

                        <h4 class="header-title mb-3">Inventory Management</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU (Stock Keeping Unit)<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sku" id="sku"
                                        value="{{ $product->sku }}" placeholder="sku" required>
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Barcode</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode"
                                        value="{{ $product->barcode }}" placeholder="Barcode">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-2 form-check-primary">
                            <input type="hidden" name="track_quantity" value="No">
                            <input class="form-check-input rounded" type="checkbox" name="track_quantity" value="Yes"
                                id="track_quantity" {{ $product->track_quantity == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="track_quantity">Track Quantity</label>
                        </div>

                        <div class="mb-3">
                            <input type="number" class="form-control" name="quantity" id="quantity"
                                value="{{ $product->quantity }}" min="0" placeholder="Quantity">
                            <p class="error"></p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="status1" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status1" required>
                                {{-- <option selected disabled value="">Choose...</option> --}}
                                <option {{ $product->status == '1' ? 'selected' : '' }} value="1">Active
                                </option>
                                <option {{ $product->status == '2' ? 'selected' : '' }} value="2">Block
                                </option>
                            </select>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="featured" class="form-label">Featured</label>
                            <select class="form-select" name="is_featured" id="featured" required>
                                {{-- <option selected disabled value="">Choose...</option> --}}
                                <option {{ $product->is_feature == 'No' ? 'selected' : '' }} value="No">No
                                </option>
                                <option {{ $product->is_feature == 'Yes' ? 'selected' : '' }} value="Yes">Yes
                                </option>
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
                                        <option {{ $product->category_id == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="subCategory" class="form-label">Sub Category</label>
                            <select class="form-select" name="subCategory" id="subCategory">
                                <option selected disabled value="">Choose...</option>
                                @if ($subCategories->isNotEmpty())
                                    @foreach ($subCategories as $subCategory)
                                        <option {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}
                                            value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                @endif
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
                                @if ($productImages->isNotEmpty())
                                    @foreach ($productImages as $image)
                                        <div id="image{{ $image->id }}"
                                            class="uploaded-img d-flex align-items-center justify-content-between rounded border p-2">
                                            <input type="text" name="images[]" value="{{ $image->id }}" hidden>
                                            <img class="rounded"
                                                src="{{ asset('uploads/products/small/' . $image->image) }}"
                                                alt="Image Preview" style="height: 60px;">
                                            <a href="javascript:void(0);" onclick="deleteImage({{ $image->id }})">
                                                <i class="fe-x"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" name="submit">Update Product</button>
                <a href="{{ route('products.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>

@endsection

@section('customJs')
    <script>
        // for getting sub category
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

        // update product 
        $('#productForm').submit(function(event) {
            event.preventDefault();
            let formArray = $(this).serializeArray();
            $('button[type="submit"]').prop('disable', true);

            $.ajax({
                url: "{{ route('products.update', $product->id) }}",
                type: 'put',
                data: formArray,
                dataType: 'json',
                success: function(response) {
                    $('button[type="submit"]').prop('disable', false);

                    if (response['status'] == true) {
                        window.location.href = "{{ route('products.index') }}";

                    } else {
                        let errors = response['errors'];

                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], textarea, select").removeClass('is-invalid');

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

        //update product image
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('product-images.update') }}",
            maxFiles: 5,
            paramName: 'image',
            params: {
                'product_id': '{{ $product->id }}'
            },
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

        //delete product image
        function deleteImage(id) {
            Swal.fire({
                    title: '<span style="color: #595959;">Are you sure?</span>',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $("#image" + id).remove();
                        $.ajax({
                            url: '{{ route('product-images.destroy') }}',
                            type: 'delete',
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    Swal.fire(
                                        '<span style="color: #595959;">Deleted!</span>',
                                        'User has been deleted.',
                                        'success'
                                    )
                                } else {
                                    alert(response.message);
                                }
                            }
                        })

                    }
                });
        }
    </script>
@endsection
