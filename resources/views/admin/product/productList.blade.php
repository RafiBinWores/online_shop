@extends('admin.layouts.main')

{{-- page title --}}
@section('page-title')
    Product List | Online Shop
@endsection

{{-- topbar page title --}}
@section('topbar-title')
    Products
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('products.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="mdi mdi-plus-circle me-1"></i> Add Product
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
            <h4 class="mt-0 header-title mb-3">All products</h4>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>SKU</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($products->isNotEmpty())
                            @foreach ($products as $product)
                                @php
                                    $productImage = $product->product_images->first();
                                @endphp
                                <tr>
                                    <th scope="row">
                                        {{ $loop->iteration + $products->perPage() * ($products->currentPage() - 1) }}
                                    </th>
                                    <td>
                                        @if (!empty($productImage->image))
                                            <img src="{{ asset('uploads/products/small/' . $productImage->image) }}"
                                                alt="" width="50px">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }} left in stock</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->is_featured }}</td>
                                    <td>
                                        @if ($product->status == 1)
                                            <i class="fe-check text-success"></i>
                                        @else
                                            <i class="fe-x text-danger"></i>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-success waves-effect waves-light">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        <a href="#" onclick="deleteProduct({{ $product->id }})"
                                            class="btn btn-danger waves-effect waves-light delete-product">
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
        {{ $products->links() }}
    </div>

@endsection


@section('customJs')
    <script>
        function deleteProduct(id) {
            let url = "{{ route('products.destroy', 'Id') }}";
            let newUrl = url.replace("Id", id);

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
                        $.ajax({
                            url: newUrl,
                            type: 'delete',
                            data: {},
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    Swal.fire(
                                        '<span style="color: #595959;">Deleted!</span>',
                                        'User has been deleted.',
                                        'success'
                                    ).then((result) => {
                                        window.location.href = "{{ route('products.index') }}";
                                    })
                                } else {
                                    window.location.href = "{{ route('products.index') }}";
                                }
                            }
                        });

                    }
                });
        };
    </script>
@endsection
