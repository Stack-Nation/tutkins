<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config("app.name")}} | @yield("title")</title>

        <link rel="icon" type="image/png" sizes="16x16" href="{{asset("assets/main/assets/images/favicon.png")}}">
        <link href="{{asset("assets/main/css/style.css")}}" rel="stylesheet">

        <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
        <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
        <!-- Material Design Icons -->
        <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link type="text/css" href="{{asset("assets/main/css/fontawesome.css")}}" rel="stylesheet">

        <style>  
            .ck-editor__editable {height: 150px;}
        </style>

        @yield('head')
    </head>

    <body>
    
        <!--*******************
            Preloader start
        ********************-->
        <div id="preloader">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        <!--*******************
            Preloader end
        ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo"><a href="{{route("home")}}"><b><img src="{{asset("assets/main/assets/images/logo.png")}}" alt=""> </b><span class="brand-title text-white ">{{config("app.name")}}</span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span>  <span class="line"></span>  <span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        @include('includes.auth-header')
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
            @if(Auth::user()->role==="Admin")
                @include('includes.admin-sidebar')
            @endif
            @if(Auth::user()->role==="Trainer")
                @include('includes.trainer-sidebar')
            @endif
            @if(Auth::user()->role==="Organiser")
                @include('includes.organiser-sidebar')
            @endif
            @if(Auth::user()->role==="Manager")
                @include('includes.manager-sidebar')
            @endif
            @if(Auth::user()->role==="Kid")
                @include('includes.kid-sidebar')
            @endif
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        @include('includes.footer')
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

        @yield("modals")
        <script src="{{asset("assets/main/assets/plugins/common/common.min.js")}}"></script>
        <script src="{{asset("assets/main/js/custom.min.js")}}"></script>
        <script src="{{asset("assets/main/js/settings.js")}}"></script>
        <script src="{{asset("assets/main/js/gleek.js")}}"></script>
        <script src="{{asset("assets/main/js/styleSwitcher.js")}}"></script>
        
        <!-- Chartjs chart -->
        <script src="{{asset("assets/main/assets/plugins/chart.js/Chart.bundle.min.js")}}"></script>
        <script src="{{asset("assets/main/assets/plugins/d3v3/index.js")}}"></script>
        <script src="{{asset("assets/main/assets/plugins/topojson/topojson.min.js")}}"></script>
        <script src="{{asset("assets/main/assets/plugins/datamaps/datamaps.world.min.js")}}"></script>

        <script src="{{asset("assets/main/js/plugins-init/datamap-world-init.js")}}"></script>

        <script src="{{asset("assets/main/assets/plugins/datamaps/datamaps.usa.min.js")}}"></script>

        <script src="{{asset("assets/main/js/dashboard/dashboard-1.js")}}"></script>

        <script src="{{asset("assets/main/js/plugins-init/datamap-usa-init.js")}}"></script>
        <script src="{{asset("assets/toastr/toastr.min.js")}}"></script>
        {{--toastr--}}
        <script>
            @if(Session()->has('success'))
                toastr.success("{{Session('success')}}")
            @endif
            @if(Session()->has('warning'))
                toastr.warning("{{Session('warning')}}")
            @endif
            @if(Session()->has('error'))
                toastr.error("{{Session('error')}}")
            @endif
            @if(count($errors)>0)
                @foreach($errors->all() as $error)
                    toastr.error("{{$error}}")
                @endforeach
            @endif
        </script>
        @yield("scripts")

    </body>

</html>