<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config("app.name")}} | @yield("title")</title>

        <!-- Prevent the demo from appearing in search engines -->
        <meta name="robots" content="noindex">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap" rel="stylesheet">

	    <!-- Vendors Style-->
        <link rel="stylesheet" href="{{asset("assets/dashboard/css/vendors_css.css")}}">
        
        <!-- Style-->  
        <link rel="stylesheet" href="{{asset("assets/dashboard/css/style.css")}}">
        <link rel="stylesheet" href="{{asset("assets/dashboard/css/skin_color.css")}}">
        <link type="text/css" href="{{asset("assets/main/css/fontawesome.css")}}" rel="stylesheet">
        <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="{{asset("assets/main/css/toastr.css")}}"/>
        <style>  
            .ck-editor__editable {height: 150px;}
        </style>

        @yield('head')
    </head>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">

        <div class="wrapper">
            <div id="loader"></div>

                <!-- Navbar -->
                    @include('includes.auth-header')
                <!-- // END Navbar -->
            <!-- Drawer -->
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

                <!-- Page Content -->
                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <div class="container-full">
                        <section class="content">
                            <div class="row">
                                <div class="col-xl-12 col-12">
                                    @yield('content')
                                    <div class="mt-4">
                                        @include('includes.footer')
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- // END Page Content -->

            </div>

            <!-- // END drawer-layout__content -->
        @yield("modals")
        <!-- // END Drawer Layout -->
	
	<!-- Vendor JS -->
        <script src="{{asset("assets/dashboard/js/vendors.min.js")}}"></script>
        <script src="{{asset("assets/dashboard/js/pages/chat-popup.js")}}"></script>
        <script src="{{asset("assets/assets/icons/feather-icons/feather.min.js")}}"></script>
    
        <script src="{{asset("assets/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js")}}"></script>
        <script src="{{asset("assets/assets/vendor_components/moment/min/moment.min.js")}}"></script>
        <script src="{{asset("assets/assets/vendor_components/fullcalendar/fullcalendar.js")}}"></script>
        
        <!-- EduAdmin App -->
        <script src="{{asset("assets/dashboard/js/template.js")}}"></script>
        <script src="{{asset("assets/main/vendor/material-design-kit.js")}}"></script>
        <script src="{{asset("assets/dashboard/js/pages/dashboard.js")}}"></script>
        <script src="{{asset("assets/dashboard/js/pages/calendar.js")}}"></script>
        <script src="{{asset("assets/toastr/toastr.min.js")}}"></script>
        <script src="{{asset("assets/main/js/toastr.js")}}"></script>
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