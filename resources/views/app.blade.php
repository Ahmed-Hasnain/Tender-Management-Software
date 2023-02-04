<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/logo/logo.png')}}">

        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendors/datatables/dataTables.bootstrap.min.css')}}" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        <!-- Core Vendors JS -->
        <script src="{{asset('assets/js/vendors.min.js')}}"></script>
        <!-- page js -->
        <script src="{{asset('assets/vendors/chartjs/Chart.min.js')}}"></script>
        <script src="{{asset('assets/js/pages/dashboard-default.js')}}"></script>
        <!-- Core JS -->
        <script src="{{asset('assets/js/app.min.js')}}"></script>
        <script src="{{asset('assets/vendors/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/vendors/datatables/dataTables.bootstrap.min.js')}}"></script>

        @env ('local')
            <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv

    </body>
</html>
