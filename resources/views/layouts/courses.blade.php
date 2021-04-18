<!doctype html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>{{config("app.name")}} | @yield("title")</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/fontawesome-all.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/flaticon.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/animate.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/jquery.fancybox.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/jquery.mCustomScrollbar.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/odometer-theme-default.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/owl.carousel.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/style.css")}}">
    <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{asset("assets/main/css/toastr.css")}}"/>
    <!-- Material Design Icons -->
    <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">
    <style>  
        .ck-editor__editable {height: 150px;}
    </style>

    @yield('head')


</head>

<body class="yl-home">
    <!-- preloader - start -->
    <div id="yl-preloader"></div>
    <div class="up">
       <a href="#" class="scrollup text-center"><i class="fas fa-chevron-up"></i></a>
    </div>
    @include('includes.courses-header')

    <div id="wrapper" class="admin-panel">

        <!-- content -->
        <div class="page-content">
                @yield('content')
                <!-- footer
                ================================================== -->
                @include('includes.courses-footer')

            </div>

        </div>
        @yield("modals")
        <!-- JS library -->
        <script src="{{asset("assets/courses/assets/js/jquery.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/popper.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/appear.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/bootstrap.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/wow.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/jquery.fancybox.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/owl.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/isotope.pkgd.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/imagesloaded.pkgd.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/masonry.pkgd.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/parallax-scroll.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/jquery.nice-select.min.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/typer.js")}}"></script>
        <script src="{{asset("assets/courses/assets/js/custom.js")}}"></script>
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