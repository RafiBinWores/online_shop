<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no, minimal-ui" />
    <link rel="shortcut icon" href="{{ asset('front-assets/img/favicon.ico') }}" />

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Questrial|Raleway:700,900" rel="stylesheet">

    <link href="{{ asset('front-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front-assets/css/bootstrap.extension.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front-assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front-assets/css/swiper.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front-assets/css/sumoselect.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

    <title>EX ZO</title>
</head>

<body>

    <!-- LOADER -->
    <div id="loader-wrapper"></div>

    <div id="content-block">
        <!-- HEADER -->

        @include('frontend.layouts.header')


        @yield('content')

        <!-- FOOTER -->
        @include('frontend.layouts.footer')
    </div>

    {{-- Login regiristartion popup --}}
    @include('frontend.layouts.loginRegistrationPopup')



    <script src="{{ asset('front-assets/js/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/swiper.jquery.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/global.js') }}"></script>

    <!-- styled select -->
    <script src="{{ asset('front-assets/js/jquery.sumoselect.min.js') }}"></script>

    <!-- counter -->
    <script src="{{ asset('front-assets/js/jquery.classycountdown.js') }}"></script>
    <script src="{{ asset('front-assets/js/jquery.knob.js') }}"></script>
    <script src="{{ asset('front-assets/js/jquery.throttle.js') }}"></script>

    {{-- custom js --}}
    @yield('customJs')

</body>

</html>
