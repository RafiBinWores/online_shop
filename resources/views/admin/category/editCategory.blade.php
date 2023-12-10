@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Edit Category | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Edit Category
@endsection

{{-- page content --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Basic Information</h4>

            @include('admin.alert')

            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Category Name" name="name" value="{{ $category->name }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="validationCustom04" class="form-label">Status</label>
                    <select class="form-select" name="status" id="validationCustom04" required>
                        <option selected disabled value="">Choose...</option>
                        <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $category->status == 2 ? 'selected' : '' }} value="2">Block</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid status.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="validationCustom05" class="form-label">Featured</label>
                    <select class="form-select" name="is_featured" id="validationCustom05" required>
                        <option selected disabled value="">Choose...</option>
                        <option {{ $category->is_featured == 'Yes' ? 'selected' : '' }} value="Yes">Yes</option>
                        <option {{ $category->is_featured == 'No' ? 'selected' : '' }} value="No">No</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid status.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Category Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                        id="image">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="position-relative">
                        <img id="image-preview" src="{{ asset('/uploads/category/' . $category->image . '') }}"
                            alt="Image Preview"
                            style="@if ($category->image == null) display: none @endif; max-width: 200px;" multiple>
                        <button type="button" id="remove-image"
                            class="btn btn-danger btn-xs position-absolute top-0 left-0 mt-1 ms-1 waves-effect waves-light"
                            style="display: none;">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{ route('categories.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>
@endsection


@section('customJs')
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const removeImageButton = document.getElementById('remove-image');

        imageInput.addEventListener('change', function() {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    removeImageButton.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        removeImageButton.addEventListener('click', function() {
            imageInput.value = null; // Clear the file input
            imagePreview.src = '#'; // Clear the image source
            imagePreview.style.display = 'none';
            removeImageButton.style.display = 'none';
        });
    </script>
@endsection
