@extends('layouts.courses')
@section("title","Webinars")
@section('content')
<!-- Start of header section
   ============================================= -->
  
   <section id="yl-breadcrumb" class="yl-breadcrumb-section position-relative" data-background="[asset]">
      <span class="breadcrumb-overlay position-absolute"></span>
      <div class="container">
         <div class="yl-breadcrumb-content text-center yl-headline"> 
            <h2>Webinars</h2>
            <div class="yl-breadcrumb-item ul-li">
               <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Webinars</li>
             </ul>
          </div>
       </div>
    </div>
 </section>
<!-- End of breadcrumb section
   ============================================= -->
      <!-- Start of course page section
         ============================================= -->
         <section id="course-page-course" class="course-page-course-section">
            <div class="container">
              <div class="course-page-course-content">
                 <div class="course-page-course-content-top">
              
                 </div>
                 <div class="course-page-courses-item"> 
                    @if($webinars->count()===0)
                    <p>No webinar found</p>
                    @else
                    <div class="row">
                        @foreach ($webinars as $webinar)
                       <div class="col-lg-4 col-md-6">
                          <div class="yl-popular-course-img-text">
                             <div class="yl-popular-course-img text-center">
                                <img src="{{asset("assets/webinars/thumbnail/".$webinar->thumbnail)}}" alt="">
                             </div>
                             <div class="yl-popular-course-text">
                                <div class="popular-course-fee clearfix">
                                   <span>Webinar Fee:  </span>
                                   <div class="course-fee-amount">
                                      <strong>{{$webinar->price}} INR</strong>
                                   </div>
                                </div>
                                <div class="popular-course-title yl-headline mb-2">
                                   <h3><a href="{{route("webinars.view",[$webinar->id,md5($webinar->title)])}}">{{$webinar->title}}</a>
                                   </h3>
                                   <div class="yl-course-meta">
                                      <a href="#"><i class="fas fa-user"></i> {{$webinar->enrolled_users()->count()}} Subscribers</a>
                                   </div>
                                </div>
                                <div class="popular-course-rate clearfix ul-li">
                                   <div class="p-course-btn float-right">
                                      <a href="{{route("webinars.view",[$webinar->id,md5($webinar->title)])}}"><i class="fas fa-chevron-right"></i></a>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                       @endforeach
                    </div>
                    @endif
                    {{$webinars->links()}}
                 </div>
              </div>
            </div>
        </section>
     <!-- End of course page section
        ============================================= -->
@endsection