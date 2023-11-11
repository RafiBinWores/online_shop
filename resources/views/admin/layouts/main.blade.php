<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('page-title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin-assets/images/favicon.ico') }}">

    {{-- Quill --}}
    <link href="{{ asset('admin-assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />

    {{-- Dropzone --}}
    <link href="{{ asset('admin-assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" />

    <!-- App css -->
    <link href="{{ asset('admin-assets/css/app.min.css') }}" rel="stylesheet" id="app-style" />

    <!-- icons -->
    <link href="{{ asset('admin-assets/css/icons.min.css') }}" rel="stylesheet" />

</head>

<!-- body start -->

<body class="loading" data-layout-color="dark" data-layout-mode="default" data-layout-size="fluid"
    data-topbar-color="dark" data-leftbar-position="fixed" data-leftbar-color="dark" data-sidebar-user='true'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        @include('admin.layouts.topbar')
        <!-- end Topbar -->

        <!--  Left Sidebar Start  -->
        @include('admin.layouts.leftBar')
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- Start Content-->
        <div class="content-page">
            <div class="content">

                @yield('content')

            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar start -->
    @include('admin.layouts.rightBar')
    <!-- Right-bar end -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy; All copyright received by <a href="">Online Shop</a>
                </div>
                <div class="col-md-6">
                    <div class="text-md-end footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

    <!-- Vendor -->
    <script src="{{ asset('admin-assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- knob plugin -->
    <script src="{{ asset('admin-assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>

    <!--Morris Chart-->
    <script src="{{ asset('admin-assets/libs/morris.js06/morris.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/raphael/raphael.min.js') }}"></script>

    <!-- Dashboar init js-->
    <script src="{{ asset('admin-assets/js/pages/dashboard.init.js') }}"></script>

    <!-- Plugins js -->
    <script src="{{ asset('admin-assets/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/quill/quill.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    {{-- <script src="{{ asset('admin-assets/libs/toastr/build/toastr.min.js') }}"></script> --}}

    <!-- Init js-->
    <script src="{{ asset('admin-assets/js/pages/form-quilljs.init.js') }}"></script>

    <!-- App js-->
    <script src="{{ asset('admin-assets/js/app.min.js') }}"></script>

    @yield('customJs')

</body>

</html>
