<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', "EducIT - onlayn kurslar platformasi")">
    <meta name="keywords"
          content="@yield('keywords', "dasturlash, it, it kurslar,android, programmalash, online, c++, python, php, web dasturlash, lifepc, lifepc group, sun'iy intellekt")">
    @yield('meta_tags')
    <meta name="author" content="Esanov Otabek">
    <meta name="generator" content="Esanov Otabek">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta property="og:image" content="@yield('og_image', Vite::asset('resources/images/logo.png'))">
    <meta name="theme-color" content="#ffffff">
    <title>
        @yield("title")
    </title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    @stack('styles')

</head>
<body  class="bg-gray-50 dark:bg-gray-800">

@yield("big-content")


@if ($errors->any())
    @foreach ($errors->all() as $error)
        <x-tools.toastr message="{{ $error }}" type="danger" icon="Error icon"/>
    @endforeach
@endif

@if(Session::has('success_msg'))
    <x-tools.toastr message="{!! session('success_msg') !!}" type="success" icon="Error icon"/>
@endif

@if(Session::has('error_msg'))
    <x-tools.toastr message="{!!  session('error_msg') !!}" type="danger" icon="Error icon"/>
@endif

@if(Session::has('success'))
    <x-tools.toastr message="{!! session('success') !!}" type="success" icon="Error icon"/>
@endif

@if(Session::has('error_msg'))
    <x-tools.toastr message="{!!  session('error_msg') !!}" type="danger" icon="Error icon"/>
@endif




<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://flowbite-admin-dashboard.vercel.app//app.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
@stack('scripts')
</body>

</html>
