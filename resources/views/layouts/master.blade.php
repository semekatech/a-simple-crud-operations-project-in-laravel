<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Products Management System</title>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="{{asset('assets/css/sb-admin-2.min.css')}}">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/images/favicon.ico') }}">
    <script type="text/javascript" src="{{asset('assets/js/jquery-3.6.4.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('assets/css/toast.css')}}">
<script type="text/javascript" src="{{asset('assets/js/toast.js')}}"></script>
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased">
<div id="wrapper">

    <!-- Sidebar -->
@include('layouts.sidebar')
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="app">
            <!-- Topbar -->
        @include('layouts.topbar')
        <!-- End of Topbar -->
            @yield('content')
        </div>
        <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->

<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
@vite('resources/js/app.js')
</body>
</html>
