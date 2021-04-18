@extends('layouts.courses')
@section("title","Courses")
@section('content')
<!-- Start of header section
   ============================================= -->
  
   <section id="yl-breadcrumb" class="yl-breadcrumb-section position-relative" data-background="[asset]">
      <span class="breadcrumb-overlay position-absolute"></span>
      <div class="container">
         <div class="yl-breadcrumb-content text-center yl-headline"> 
            <h2>Courses</h2>
            <div class="yl-breadcrumb-item ul-li">
               <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Courses</li>
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
                    @if($courses->count()===0)
                    <p>No course found</p>
                    @else
                    <div class="row">
                        @foreach ($courses as $course)
                        <?php 
                            $ratings = 0;
                            if($course->ratings === NULL){
                                $ratings = 0;
                            }
                            else{
                                $totalr = count($course->ratings);
                                foreach ($course->ratings as $r) {
                                    $ratings = $ratings + (int)$r->stars;
                                }
                                $ratings = $ratings / $totalr;
                            }
                        ?>
                       <div class="col-lg-4 col-md-6">
                          <div class="yl-popular-course-img-text">
                             <div class="yl-popular-course-img text-center">
                                <img src="{{asset("assets/courses/image/".$course->image)}}" alt="">
                             </div>
                             <div class="yl-popular-course-text">
                                <div class="popular-course-fee clearfix">
                                   <span>Course Fee:  </span>
                                   <div class="course-fee-amount">
                                      <strong>{{$course->price}} INR</strong>
                                   </div>
                                </div>
                                <div class="popular-course-title yl-headline">
                                   <h3><a href="{{route("courses.view",[$course->id,md5($course->title)])}}">{{$course->title}}</a>
                                   </h3>
                                   <div class="yl-course-meta">
                                      <a href="#"><i class="fas fa-file"></i>{{count(array_keys(get_object_vars(json_decode($course->content))))}} Sections</a>
                                      <a href="#"><i class="fas fa-user"></i> {{$course->enrolled_users()->count()}} Students</a>
                                   </div>
                                </div>
                                <div class="popular-course-rate clearfix ul-li">
                                   <div class="p-rate-vote float-left">
                                    <div class="ratings" data-rating-value="{{$ratings}}"></div>
                                      <span>({{$course->ratings===NULL ? 0: count($course->ratings)}} Votes)</span>
                                   </div>
                                   <div class="p-course-btn float-right">
                                      <a href="{{route("courses.view",[$course->id,md5($course->title)])}}"><i class="fas fa-chevron-right"></i></a>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                       @endforeach
                    </div>
                    @endif
                    {{$courses->links()}}
                 </div>
              </div>
            </div>
        </section>
     <!-- End of course page section
        ============================================= -->
@endsection
@section('scripts')
<script src="{{asset("assets/rating/rating.js")}}"></script>
<script>
    window.onload = () => { 
        ratings = $(".ratings");
        ratings.map((key,rating) => {
            const stars = $(rating).data("rating-value");
            $(rating).rating({
                readonly:true,
                value:stars
            });
        });
    }
</script>
@endsection