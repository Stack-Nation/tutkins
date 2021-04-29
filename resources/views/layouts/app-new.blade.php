<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config("app.name")}} | @yield("title")</title>
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">
    
        <!-- CSS Global Compulsory (Do not remove)-->
        <link rel="stylesheet" href="{{asset("assets/new/css/font-awesome/all.min.css")}}" />
        <link rel="stylesheet" href="{{asset("assets/new/css/flaticon/flaticon.css")}}" />
        <link rel="stylesheet" href="{{asset("assets/new/css/bootstrap/bootstrap.min.css")}}" />
    
        <!-- Page CSS Implementing Plugins (Remove the plugin CSS here if site does not use that feature)-->
        <link rel="stylesheet" href="{{asset("assets/new/css/select2/select2.css")}}" />
    
        <!-- Template Style -->
        <link rel="stylesheet" href="{{asset("assets/new/css/style.css")}}" />
        <!-- Material Design Icons -->
        <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">
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
        @include("includes.navbar")
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body" style="margin-left:0">
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

        <script src="{{asset("assets/new/js/jquery-3.4.1.min.js")}}"></script>
        <script src="{{asset("assets/new/js/popper/popper.min.js")}}"></script>
        <script src="{{asset("assets/new/js/bootstrap/bootstrap.min.js")}}"></script>
    
        <!-- Page JS Implementing Plugins (Remove the plugin script here if site does not use that feature)-->
        <script src="{{asset("assets/new/js/select2/select2.full.js")}}"></script>
    
        <!-- Template Scripts (Do not remove)-->
        <script src="{{asset("assets/new/js/custom.js")}}"></script>
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