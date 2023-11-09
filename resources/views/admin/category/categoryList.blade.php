@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Category List | Online Shop - Responsive Admin Dashboard
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Categories
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus-circle me-1"></i> Add category
                        </a>
                    </div>
                </div><!-- end col-->
                <div class="col-md-8">
                    <form action="" method="GET" class="d-flex flex-wrap align-items-center justify-content-sm-end">
                        @csrf
                        @method('get')
                        {{-- <label for="status-select" class="me-2">Sort By</label>
                        <div class="me-sm-2">
                            <select class="form-select my-1 my-md-0" id="status-select">
                                <option selected="">All</option>
                                <option value="1">Name</option>
                                <option value="2">Post</option>
                                <option value="3">Followers</option>
                                <option value="4">Followings</option>
                            </select>
                        </div> --}}
                        <label for="inputPassword2" class="visually-hidden">Search</label>
                        <div>
                            <input type="search" name="keyword" value="{{ Request::get('keyword') }}"
                                class="form-control my-1 my-md-0" id="inputPassword2" placeholder="Search...">
                        </div>
                    </form>
                </div>
            </div> <!-- end row -->
        </div>
    </div>

    {{-- alert --}}
    @include('admin.alert')

    {{-- category table --}}
    <div class="card">
        <div class="card-body">
            <h4 class="mt-0 header-title mb-3">All categories</h4>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Sub Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($categories->isNotEmpty())
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">
                                        {{ $loop->iteration + $categories->perPage() * ($categories->currentPage() - 1) }}
                                    </th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->subcategory_count }}</td>
                                    <td>
                                        @if ($category->status == 1)
                                            <i class="fe-check text-success"></i>
                                        @else
                                            <i class="fe-x text-danger"></i>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="btn btn-success waves-effect waves-light">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <a href="{{ route('categories.destroy', $category->id) }}"
                                            class="btn btn-danger waves-effect waves-light delete-subcategory">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="5">No Records Found!</td>
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- pagination --}}
    <div class="pagination-rounded">
        {{ $categories->links() }}
    </div>

@endsection


@section('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-subcategory');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');

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
                                Swal.fire(
                                    '<span style="color: #595959;">Deleted!</span>',
                                    'User has been deleted.',
                                    'success'
                                ).then((result) => {
                                    window.location.href = deleteUrl;
                                })
                            }
                        });
                });
            });
        });
    </script>
@endsection
