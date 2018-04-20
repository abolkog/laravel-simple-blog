<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{  config('app.name', 'My Blog' )  }}</title>

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/extra.css') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


    <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.1/js/all.js"></script>

</head>
<body>
    
    
    @include('elements.navbar')
    <div class="container">
        @include('elements.flash') 
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    
    @yield('javascript')

</body>
</html>