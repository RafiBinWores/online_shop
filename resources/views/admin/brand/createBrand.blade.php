@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Add Brand | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Add Brand
@endsection

{{-- page content --}}
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="header-title mb-3">Add New Brand</h4>

            @include('admin.alert')

            <form action="{{ route('brands.index') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
                novalidate>
                @csrf
                @method('post')
                <div class="mb-3">
                    <label for="name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Brand Name" name="name" value="{{ old('name') }}" required>
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
                        <option value="1">Active</option>
                        <option value="2">Block</option>
                    </select>
                    <div class="invalid-feedback">
                        Please select a valid status.
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Add Brand</button>
                <a href="{{ route('brands.index') }}" type="reset" class="btn btn-secondary waves-effect">Cancel</a>
            </form>

        </div> <!-- end card-body-->
    </div>
@endsection
