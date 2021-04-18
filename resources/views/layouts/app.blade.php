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

        <link type="text/css" href="{{asset("assets/main/vendor/spinkit.css")}}" rel="stylesheet">

        <!-- Perfect Scrollbar -->
        <link type="text/css" href="{{asset("assets/main/vendor/perfect-scrollbar.css")}}" rel="stylesheet">

        <!-- Material Design Icons -->
        <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link type="text/css" href="{{asset("assets/main/css/fontawesome.css")}}" rel="stylesheet">

        <!-- Preloader -->
        <link type="text/css" href="{{asset("assets/main/css/preloader.css")}}" rel="stylesheet">

        <!-- App CSS -->
        <link type="text/css" href="{{asset("assets/main/css/app.css")}}" rel="stylesheet">
        <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="{{asset("assets/main/css/toastr.css")}}"/>
        <style>  
            .ck-editor__editable {height: 150px;}
        </style>

        @yield('head')
    </head>

    <body class="layout-app ">

        <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div>

        <!-- Drawer Layout -->

        <div class="mdk-drawer-layout js-mdk-drawer-layout"
             data-push
             data-responsive-width="992px">
            <div class="mdk-drawer-layout__content page-content">

                <!-- Navbar -->
                    @include('includes.navbar')
                <!-- // END Navbar -->

                <!-- BEFORE Page Content -->

                <!-- // END BEFORE Page Content -->

                <!-- Page Content -->
                    @yield('content')
                <!-- // END Page Content -->
                @include('includes.footer')

            </div>

            <!-- // END drawer-layout__content -->

            <!-- Drawer -->
                {{-- Sidebar here --}}
            <!-- // END Drawer -->

        </div>
        @yield("modals")

        <!-- // END Drawer Layout -->

        <!-- jQuery -->
        <script src="{{asset("assets/main/vendor/jquery.min.js")}}"></script>

        <!-- Bootstrap -->
        <script src="{{asset("assets/main/vendor/popper.min.js")}}"></script>
        <script src="{{asset("assets/main/vendor/bootstrap.min.js")}}"></script>

        <!-- Perfect Scrollbar -->
        <script src="{{asset("assets/main/vendor/perfect-scrollbar.min.js")}}"></script>

        <!-- DOM Factory -->
        <script src="{{asset("assets/main/vendor/dom-factory.js")}}"></script>

        <!-- MDK -->
        <script src="{{asset("assets/main/vendor/material-design-kit.js")}}"></script>

        <!-- App JS -->
        <script src="{{asset("assets/main/js/app.js")}}"></script>

        <!-- Preloader -->
        <script src="{{asset("assets/main/js/preloader.js")}}"></script>
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