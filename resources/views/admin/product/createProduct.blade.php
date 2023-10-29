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
                novalidate>
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Product Name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom03" class="form-label">Brand</label>
                            <select class="form-select" name="brand" id="validationCustom03">
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid option.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price" value=""
                                        placeholder="Price" required>
                                    <div class="invalid-feedback">
                                        Please select a valid option.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom05" class="form-label">Comapre Price</label>
                                    <input type="number" class="form-control" name="compare_price" id="compare_price"
                                        value="" placeholder="Compare Price">
                                    <div class="invalid-feedback">
                                        Please select a valid option.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="example-textarea" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <div id="snow-editor" style="height: 250px;"></div>
                            <textarea name="description" id="description" class="form-control" style="display: none;" required></textarea>
                            <div class="invalid-feedback">
                                Please enter product description.
                            </div>
                        </div>

                        <h4 class="header-title mb-3">Inventory Management</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU (Stock Keeping Unit)<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="sku" id="sku" value=""
                                        placeholder="sku" required>
                                    <div class="invalid-feedback">
                                        Please select a valid option.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode" class="form-label">Barcode</label>
                                    <input type="text" class="form-control" name="barcode" id="barcode" value=""
                                        placeholder="Barcode">
                                    <div class="invalid-feedback">
                                        Please select a valid option.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-2 form-check-primary">
                            <input class="form-check-input rounded-circle" type="checkbox" name="track_quantity"
                                value="" id="track_quantity" checked="">
                            <label class="form-check-label" for="track_quantity">Track Quantity</label>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="quantity" id="quantity" value=""
                                placeholder="Quantity">
                            <div class="invalid-feedback">
                                Please select a valid option.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="validationCustom04" class="form-label">Status</label>
                            <select class="form-select" name="status" id="validationCustom04" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid option.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="validationCustom04" class="form-label">Category<span
                                    class="text-danger">*</span></label>
                            <select class="form-select" name="category" id="validationCustom04" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid option.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom05" class="form-label">Sub Category</label>
                            <select class="form-select" name="sub_category" id="validationCustom05">
                                <option selected disabled value="">Choose...</option>
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid option.
                            </div>
                        </div>

                        {{-- product image --}}
                        <h4 class="header-title mb-3">Product Image</h4>
                        <div class="mb-3 rounded position-relative" style="height: 230px; border:1px dashed #424c5c;">
                            <input type="file" name="thumbnail" id="thumbnail" hidden>
                            <div id="thumbnail-view"
                                class="h-100 d-flex align-items-center justify-content-center flex-column"
                                style="cursor: pointer;">
                                <img src="#" alt="" id="thumbnail-preview" class="rounded w-100 h-100"
                                    style="display: none; object-fit: contain;">

                                <div id="input-box" class="text-center" style="display: block;">
                                    <i class="fe-upload-cloud fs-1"></i>
                                    <h4>Click to upload thumbnail image</h4>
                                </div>
                            </div>
                            <button type="button" id="remove-thumbnail"
                                class="btn btn-danger btn-xs position-absolute top-0 end-0 mt-1 me-1 waves-effect waves-light"
                                style="display: none;">
                                <i class="mdi mdi-close"></i>
                            </button>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="rounded position-relative" style="height: 120px; border:1px dashed #424c5c;">
                                    <input type="file" name="image1" id="image1" hidden>
                                    <div id="image-view1"
                                        class="h-100 d-flex align-items-center justify-content-center flex-column"
                                        style="cursor: pointer;">
                                        <img src="#" alt="" id="image-preview1"
                                            class="rounded w-100 h-100" style="display: none; object-fit: contain;">

                                        <div id="input-box1" class="text-center" style="display: block;">
                                            <i class="fe-upload-cloud fs-1"></i>
                                            <p class="text-center m-0">Click to upload image</p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-image1"
                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 mt-1 me-1 waves-effect waves-light"
                                        style="display: none;">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rounded position-relative" style="height: 120px; border:1px dashed #424c5c;">
                                    <input type="file" name="image2" id="image2" hidden>
                                    <div id="image-view2"
                                        class="h-100 d-flex align-items-center justify-content-center flex-column"
                                        style="cursor: pointer;">
                                        <img src="#" alt="" id="image-preview2"
                                            class="rounded w-100 h-100" style="display: none; object-fit: contain;">

                                        <div id="input-box2" class="text-center" style="display: block;">
                                            <i class="fe-upload-cloud fs-1"></i>
                                            <p class="text-center m-0">Click to upload image</p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-image2"
                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 mt-1 me-1 waves-effect waves-light"
                                        style="display: none;">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rounded position-relative" style="height: 120px; border:1px dashed #424c5c;">
                                    <input type="file" name="image3" id="image3" hidden>
                                    <div id="image-view3"
                                        class="h-100 d-flex align-items-center justify-content-center flex-column"
                                        style="cursor: pointer;">
                                        <img src="#" alt="" id="image-preview3"
                                            class="rounded w-100 h-100" style="display: none; object-fit: contain;">

                                        <div id="input-box3" class="text-center" style="display: block;">
                                            <i class="fe-upload-cloud fs-1"></i>
                                            <p class="text-center m-0">Click to upload image</p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-image3"
                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 mt-1 me-1 waves-effect waves-light"
                                        style="display: none;">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rounded position-relative" style="height: 120px; border:1px dashed #424c5c;">
                                    <input type="file" name="image4" id="image4" hidden>
                                    <div id="image-view4"
                                        class="h-100 d-flex align-items-center justify-content-center flex-column"
                                        style="cursor: pointer;">
                                        <img src="#" alt="" id="image-preview4"
                                            class="rounded w-100 h-100" style="display: none; object-fit: contain;">

                                        <div id="input-box4" class="text-center" style="display: block;">
                                            <i class="fe-upload-cloud fs-1"></i>
                                            <p class="text-center m-0">Click to upload image</p>
                                        </div>
                                    </div>
                                    <button type="button" id="remove-image4"
                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 mt-1 me-1 waves-effect waves-light"
                                        style="display: none;">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-text">You need to add atleast thumbnail image.</div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Add Product</button>
                <a href="{{ route('brands.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>
@endsection


@section('customJs')
    <script>
        function setupImageInputHandlers(inputId, previewId, removeButtonId, inputBoxId, imageViewId) {
            const imageInput = document.getElementById(inputId);
            const imagePreview = document.getElementById(previewId);
            const removeImageButton = document.getElementById(removeButtonId);
            const inputBox = document.getElementById(inputBoxId);
            const imageView = document.getElementById(imageViewId);

            imageView.onclick = () => imageInput.click();

            imageInput.addEventListener('change', function() {
                const file = imageInput.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        removeImageButton.style.display = 'block';
                        inputBox.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });

            removeImageButton.addEventListener('click', function() {
                imageInput.value = null; // Clear the file input
                imagePreview.src = '#'; // Clear the image source
                imagePreview.style.display = 'none';
                removeImageButton.style.display = 'none';
                inputBox.style.display = 'block';
            });
        }

        // Setup handlers for all three image input fields
        setupImageInputHandlers('thumbnail', 'thumbnail-preview', 'remove-thumbnail', 'input-box', 'thumbnail-view');
        setupImageInputHandlers('image1', 'image-preview1', 'remove-image1', 'input-box1', 'image-view1');
        setupImageInputHandlers('image2', 'image-preview2', 'remove-image2', 'input-box2', 'image-view2');
        setupImageInputHandlers('image3', 'image-preview3', 'remove-image3', 'input-box3', 'image-view3');
        setupImageInputHandlers('image4', 'image-preview4', 'remove-image4', 'input-box4', 'image-view4');
    </script>
@endsection
