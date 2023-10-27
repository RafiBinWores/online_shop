@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Edit Brand | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Edit Brand
@endsection

{{-- page content --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Edit Brand</h4>

            @include('admin.alert')

            <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Category Name" name="name" value="{{ $brand->name }}" required>
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
                        <option {{ $brand->status == 1 ? 'selected' : '' }} value="1">Active</option>
                        <option {{ $brand->status == 2 ? 'selected' : '' }} value="2">Block</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid status.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{ route('categories.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>
@endsection
