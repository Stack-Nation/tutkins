<!DOCTYPE html>
<html class="no-js" lang="">


<!-- Mirrored from radiustheme.com/demo/html/cirkle/user-groups.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Mar 2021 09:46:49 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config("app.name")}} | @yield("title")</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset("assets/groups/assets/scss/icons.html")}}">

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset("assets/courses/assets/css/bootstrap.min.css")}}">
   <link rel="stylesheet" href="{{asset("assets/groups/assets/css/style.css")}}">
    <link rel="stylesheet" href="{{asset("assets/groups/assets/css/icons.css")}}"> 

    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link type="text/css" href="{{asset("assets/main/css/fontawesome.css")}}" rel="stylesheet">
    <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
    <link type="text/css" rel="stylesheet" href="{{asset("assets/main/css/toastr.css")}}"/>
    <!-- Material Design Icons -->
    <link type="text/css" href="{{asset("assets/main/css/material-icons.css")}}" rel="stylesheet">
    <style>  
        .ck-editor__editable {height: 150px;}
    </style>

    @yield('head')
</head>

<body>
    <div id="wrapper">
        <!-- Top Header -->
        @include('includes.group-header')
        <div class="main_content">
            <div class="mcontainer">
                @yield('content')
            </div>
        </div>
        @include('includes.group-footer')
    </div>
    @yield("modals")
    <!-- Jquery Js -->
    <script src="{{asset("assets/groups/assets/js/jquery-3.3.1.min.js")}}"></script>
    <script src="{{asset("assets/groups/assets/js/uikit.js")}}"></script>
    <script src="{{asset("assets/courses/assets/js/popper.min.js")}}"></script>
    <script src="{{asset("assets/courses/assets/js/appear.js")}}"></script>
    <script src="{{asset("assets/courses/assets/js/bootstrap.min.js")}}"></script>
    <script src="{{asset("assets/groups/assets/js/simplebar.js")}}"></script>
    <script src="{{asset("assets/groups/assets/js/custom.js")}}"></script>
    <script src="{{asset("assets/groups/assets/js/bootstrap-select.min.js")}}"></script>

    <!-- Site Scripts -->
    <script src="{{asset("assets/groups/assets/js/app.js")}}"></script>
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


<!-- Mirrored from radiustheme.com/demo/html/cirkle/user-groups.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 14 Mar 2021 09:46:52 GMT -->
</html>