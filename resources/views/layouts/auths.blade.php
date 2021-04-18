<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{config("app.name")}} | @yield("title")</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="TAM" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link type="text/css" href="{{asset("assets/toastr/toastr.min.css")}}" rel="stylesheet" />
        <link type="text/css" rel="stylesheet" href="{{asset("assets/main/css/toastr.css")}}"/>
        <link rel="stylesheet" href="{{asset("assets/auth/css/e-learn.style.min.css")}}">
        <style>  
            .ck-editor__editable {height: 150px;}
        </style>

        @yield('head')

    </head>


    <body>
        <div id="elearn-layout" class="theme-black">
        
            <!-- main body area -->
            <div class="main p-2 py-3 p-xl-5 ">
                
                <!-- Body: Body -->
                <div class="body d-flex p-0 p-xl-5">
                    <div class="container-xxl">
        
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                                <div style="max-width: 25rem;">
                                    <div class="text-center mb-5">
                                        <svg  width="4rem"  fill="none" class="bi bi-app-indicator" viewBox="0 0 16 16">
                                            <path class="fill-primary" d="M5.5 2A3.5 3.5 0 0 0 2 5.5v5A3.5 3.5 0 0 0 5.5 14h5a3.5 3.5 0 0 0 3.5-3.5V8a.5.5 0 0 1 1 0v2.5a4.5 4.5 0 0 1-4.5 4.5h-5A4.5 4.5 0 0 1 1 10.5v-5A4.5 4.5 0 0 1 5.5 1H8a.5.5 0 0 1 0 1H5.5z"/>
                                            <path class="fill-primary" d="M16 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        </svg>
                                    </div>
                                    <div class="mb-5">
                                        <h2 class="color-900 text-center">Cloud-Based Mentoring Platform</h2>
                                    </div>
                                    <!-- Image block -->
                                    <div class="">
                                        <img src="{{asset("assets/auth/images/online-study.svg")}}" alt="online-study">
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                                <div class="w-100 p-4 p-md-5 card border-0 bg-dark text-light" style="max-width: 32rem;">
                                    <!-- Form -->
                                        @yield("content")
                                    <!-- End Form -->
                                    
                                </div>
                            </div>
                        </div> <!-- End Row -->
                        
                    </div>
                </div>
        
            </div>
        
        </div>
        @yield("modals")

        <script src="{{asset("assets/auth/bundles/libscripts.bundle.js")}}"></script>
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