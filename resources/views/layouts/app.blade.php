<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aplikasi Billing RTRWNET " name="description" />
    <meta content="BillingRTRWNET" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$title ?? ''}} | {{config('app.name')}}</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/notify/simple-notify.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/sweetalert2/dist/sweetalert2.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    @stack('styles')
</head>
<body data-sidebar="dark">
<div id="layout-wrapper">
    <x-header/>
    <x-sidebar/>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                {{$slot}}
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © {{config('app.name')}}.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by mikrotikbot
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('libs/metismenu/dist/metisMenu.min.js')}}"></script>
<script src="{{asset('libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('libs/node-waves/dist/waves.min.js')}}"></script>
<script src="{{asset('libs/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('libs/notify/simple-notify.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('libs/datatables/datatables.min.js')}}"></script>
@stack('scripts')
</body>
</html>
