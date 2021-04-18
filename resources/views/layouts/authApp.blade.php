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
            @if(Auth::user()->role==="Instructor")
                @include('includes.instructor-sidebar')
            @endif
            @if(Auth::user()->role==="Mentee")
                @include('includes.mentee-sidebar')
            @endif
            @if(Auth::user()->role==="Manager")
                @include('includes.manager-sidebar')
            @endif
            @if(Auth::user()->role==="Organisation")
                @include('includes.org-sidebar')
            @endif
            @if(Auth::user()->role==="Institution")
                @include('includes.inst-sidebar')
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