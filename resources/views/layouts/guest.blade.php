<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if(config('app.env') == 'production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    @else

    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
    <!--  css di sini-->
    <!-- Bootstrap Css -->
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    @stack('styles')
</head>
<body>
{{$slot}}
<script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('libs/metismenu/dist/metisMenu.min.js')}}"></script>
<script src="{{asset('libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('libs/node-waves/dist/waves.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
