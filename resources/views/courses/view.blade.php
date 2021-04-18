<?php 
    $ratings = 0;
    $ratings5 = 0;
    $ratings4 = 0;
    $ratings3 = 0;
    $ratings2 = 0;
    $ratings1 = 0;
    if($course->ratings === NULL){
        $ratings = 0;
    }
    else{
        $totalr = count($course->ratings);
        foreach ($course->ratings as $r) {
            $ratings = $ratings + (int)$r->stars;
            if((int)$r->stars===5){
                $ratings5++;
            }
            elseif((int)$r->stars===4){
                $ratings4++;
            }
            elseif((int)$r->stars===3){
                $ratings3++;
            }
            elseif((int)$r->stars===2){
                $ratings2++;
            }
            elseif((int)$r->stars===1){
                $ratings1++;
            }
        }
        $ratings = $ratings / $totalr;
        $ratings5 = (int)(($ratings5 / $totalr)*100);
        $ratings4 = (int)(($ratings4 / $totalr)*100);
        $ratings3 = (int)(($ratings3 / $totalr)*100);
        $ratings2 = (int)(($ratings2 / $totalr)*100);
        $ratings1 = (int)(($ratings1 / $totalr)*100);
    }
?>
@extends('layouts.courses')
@section("title",$course->title)
@section('content')
<section id="yl-breadcrumb" class="yl-breadcrumb-section position-relative" data-background="{{asset("assets/courses/image/".$course->image)}}">
   <span class="breadcrumb-overlay position-absolute"></span>
   <div class="container">
      <div class="yl-breadcrumb-content text-center yl-headline"> 
         <h2>{{$course->title}}</h2>
         <div class="yl-breadcrumb-item ul-li">
            <ul class="breadcrumb">
             <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">{{$course->category->name}}</li>
          </ul>
       </div>
    </div>
 </div>
</section>
<section id="course-details" class="course-details-section">
   <div class="container">
      <div class="course-details-content">
         <div class="row">
            <div class="col-lg-9">
               <div class="course-details-tab-area">
                  <div class="course-details-tab-wrapper">
                     <div class="course-details-tab-btn clearfix ul-li">
                        <ul id="tabs" class="nav text-uppercase nav-tabs">
                           <li class="nav-item"><a href="#" data-target="#overview" data-toggle="tab" class="nav-link text-capitalize active">Overview </a></li>
                           <li class="nav-item"><a href="#" data-target="#curriculm" data-toggle="tab" class="nav-link text-capitalize">Curriculum  </a></li>
                           <li class="nav-item"><a href="#" data-target="#instructor" data-toggle="tab" class="nav-link text-capitalize">Instructor</a></li>
                           <li class="nav-item"><a href="#" data-target="#review" data-toggle="tab" class="nav-link text-capitalize">Reviews </a></li>
                        </ul>
                     </div>
                     <div class="course-details-tab-content-wrap">
                        <div id="tabsContent" class="tab-content">
                           <div id="overview" class="tab-pane fade  active show">
                              <div class="course-details-overview yl-headline pera-content">
                                 <div class="course-overview-text">
                                    <h3 class="c-overview-title">Course details</h3>
                                    <div>{!!$course->description!!}</div>
                                 </div>
                                 <div class="course-details-overview-feature">
                                    <h3 class="c-overview-title">What you’ll learn</h3>
                                    <ul class="list-unstyled">
                                        @foreach($course->learnings as $learning)
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">{{$learning}}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                 </div>
                                 <div class="course-details-overview-feature">
                                    <h3 class="c-overview-title">Requirements</h3>
                                    <ul class="list-unstyled">
                                        @foreach($course->requirements as $requirement)
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">{{$requirement}}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                 </div>
                                 <div class="course-details-overview-feature">
                                    <h3 class="c-overview-title">Who this course is for</h3>
                                    <ul class="list-unstyled">
                                        @foreach($course->target as $target)
                                        <li class="d-flex align-items-center">
                                            <span class="material-icons text-50 mr-8pt">check</span>
                                            <span class="text-70">{{$target}}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div id="curriculm" class="tab-pane fade">
                              <div class="cd-curriculam-top clearfix">
                                 <h3 class="c-overview-title float-left">Course Curriculum </h3>
                                 <div class="cd-curriculam-time-lesson float-right">
                                    <span>{{count(array_keys(get_object_vars(($course->content))))}} Sections</span>
                                 </div>
                              </div>
                              <div class="accordion" id="accordionExample">
                                <?php $i=0; ?>
                                @foreach($course->content as $key => $content)
                                 <div class="yl-cd-cur-accordion yl-headline pera-content ul-li">
                                    <div class="yl-cd-cur-accordion-header" id="headingOne">
                                       <button data-toggle="collapse" data-target="#{{$i}}" aria-controls="{{$i}}">
                                          <h3>{{$key}}   </h3>
                                          <div class="cd-curriculam-time-lesson float-right">
                                             <span>{{count($content->content)}} Lesson</span>
                                          </div>
                                       </button>
                                    </div>
                                    <div id="{{$i}}" class="collapse show" data-parent="#accordionExample">
                                       <div class="yl-cd-cur-accordion-body">
                                          <ul>
                                            @foreach($content->content as $data)
                                            <li> 
                                                <i class="fas fa-play"></i> @if($data->type==="quiz")Quiz: @endif{{$data->lecture_title}}
                                            </li>
                                            @endforeach
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                                 <?php $i++; ?>
                                @endforeach
                              </div>
                           </div>
                           <div id="instructor" class="tab-pane fade">
                              <div class="cd-course-instructor yl-headline pera-content clearfix">
                                 <h3 class="c-overview-title">Course Instructors</h3>
                                 <div class="cd-course-instructor-img-text clearfix">
                                    <div class="cd-course-instructor-img float-left">
                                       <img src="@if($course->instructor->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$course->instructor->photo)}} @endif" alt="">
                                    </div>
                                    <div class="cd-course-instructor-text">
                                       <h3><a href="{{route("user.view",[$course->instructor->id,md5($course->instructor->name)])}}">{{$course->instructor->name}}</a></h3>
                                       <div class="cd-ins-course-student">
                                          <span><i class="fas fa-list-ul"></i> {{$course->instructor->courses->count()}} Course</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cd-ins-details">
                                    {!!$course->instructor->description!!}
                                 </div>
                              </div>
                           </div>
                           <div id="review" class="tab-pane fade">
                            <div class="page-section border-bottom-2">
                                <div class="container">
                                    <div class="page-headline text-center">
                                        <h2>Feedback</h2>
                                    </div>
                            
                                    <div class="container page__container">
                                        <div class="page-separator">
                                            <div class="page-separator__text">Student Feedback</div>
                                        </div>
                                        <div class="row mb-32pt">
                                            <div class="col-md-3 mb-32pt mb-md-0">
                                                <div class="display-1">{{$ratings}}</div>
                                                <div class="rating rating-24">
                                                    <div id="fratings" style="font-size:1rem" data-rating-value="{{$ratings}}"></div>
                                                </div>
                                                <p class="text-muted mb-0">{{$course->ratings===NULL ? 0: count($course->ratings)}} ratings</p>
                                            </div>
                                            <div class="col-md-9">
                                
                                                <div class="row align-items-center mb-8pt"
                                                     data-toggle="tooltip"
                                                     data-title="{{$ratings5}}% rated 5/5"
                                                     data-placement="top">
                                                    <div class="col-md col-sm-6">
                                                        <div class="progress"
                                                             style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{$ratings5}}"
                                                                 style="width: {{$ratings5}}%"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                                        <div class="rating">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-8pt"
                                                     data-toggle="tooltip"
                                                     data-title="{{$ratings4}}% rated 4/5"
                                                     data-placement="top">
                                                    <div class="col-md col-sm-6">
                                                        <div class="progress"
                                                             style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{$ratings4}}"
                                                                 style="width: {{$ratings4}}%"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                                        <div class="rating">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-8pt"
                                                     data-toggle="tooltip"
                                                     data-title="{{$ratings3}}% rated 3/5"
                                                     data-placement="top">
                                                    <div class="col-md col-sm-6">
                                                        <div class="progress"
                                                             style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{$ratings3}}"
                                                                 style="width: {{$ratings3}}%"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                                        <div class="rating">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-8pt"
                                                     data-toggle="tooltip"
                                                     data-title="{{$ratings2}}% rated 2/5"
                                                     data-placement="top">
                                                    <div class="col-md col-sm-6">
                                                        <div class="progress"
                                                             style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{$ratings2}}"
                                                                 style="width: {{$ratings2}}%"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                                        <div class="rating">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-8pt"
                                                     data-toggle="tooltip"
                                                     data-title="{{$ratings1}}% rated 0/5"
                                                     data-placement="top">
                                                    <div class="col-md col-sm-6">
                                                        <div class="progress"
                                                             style="height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{$ratings1}}"
                                                                 style="width: {{$ratings1}}%"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                                        <div class="rating">
                                                            <span class="rating__item"><span class="material-icons">star</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                            <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                            </div>
                                        </div>
                                        
                                        @if($course->ratings === NULL)
                                            <p>No feedback found.</p>
                                        @else
                                        @foreach($course->ratings as $f)
                                        <?php
                                            $student = \App\Models\User::find($f->user_id)
                                        ?>
                                        <div class="pb-16pt mb-16pt border row shadow-sm p-3">
                                            <div class="col-md-3 mb-16pt mb-md-0">
                                                <div class="d-flex">
                                                    <a href="student-profile.html"
                                                       class="avatar avatar-sm mr-12pt">
                                                        <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                                                        <span class="avatar-title rounded-circle">
                                                            <img src="@if($student->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$student->photo)}} @endif"
                                                            alt="{{$f->user_id}}"
                                                            class="rounded-circle"
                                                            width="64">
                                                        </span>
                                                    </a>
                                                    <div class="flex">
                                                        <a href="#!"
                                                           class="card-title">{{$student->name}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="rating mb-8pt">
                                                    <div class="uratings" style="font-size:1rem" data-rating-value="{{$f->stars}}"></div>
                                                </div>
                                                {!!$f->feedback!!}
                                            </div>
                                        </div>
                                        <br>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3">
               <div class="course-details-widget">
                  <div class="course-widget-wrap">
                     <div class="cd-video-widget position-relative">
                        <img src="{{asset("assets/courses/image/".$course->image)}}" alt="">
                        <a class="video_box text-center" href="#"><i class="fas fa-play"></i></a>
                     </div>
                  </div>
                  <div class="course-widget-wrap">
                     <div class="cd-course-table-widget">
                        <div class="cd-course-table-list">
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-clock"></i> Last Updated : </span>
                              <span class="cd-table-valur float-right">{{\Carbon\Carbon::parse($course->updated_at)->diffForHumans()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-users"></i> Students  : </span>
                              <span class="cd-table-valur float-right">{{$course->enrolled_users->count()}}</span>
                           </div>  
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-user"></i> Level : </span>
                              <span class="cd-table-valur float-right">{{$course->level}}</span>
                           </div> 
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-file-alt"></i> Sections : </span>
                              <span class="cd-table-valur float-right">{{count(array_keys(get_object_vars(($course->content))))}}</span>
                           </div> 
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-paste"></i> Certificate : </span>
                              <span class="cd-table-valur float-right">Yes</span>
                           </div> 
                        </div>
                        <div class="cd-course-price clearfix">
                           <span>Price: {{$course->price==0?"FREE":$course->price." INR"}}<strong></strong></span>
                           @auth
                           @if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()!==NULL)
                           <a href="{{route("mentee.courses.view",[$course->id,md5($course->title),0,0])}}"> 
                            <i class="fa fa-play"></i> Enrolled </a>
                           @else 
                           <a href="{{route("courses.enroll.add",$course->id)}}"> <i class="fa fa-play"></i> Enroll </a>
                           @endif
                           @else
                           <a href="{{route("login")}}"> Login </a>
                           @endauth
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{asset("assets/rating/rating.js")}}"></script>
<script>
    window.onload = () => { 
        const stars = $("#ratings").data("rating-value");
        $("#ratings").rating({
            readonly:true,
            value:stars
        }); 
        const fstars = $("#fratings").data("rating-value");
        $("#fratings").rating({
            readonly:true,
            value:fstars
        });
        const uratings = $(".uratings");
        uratings.map((key,urating) => {
            let ustars = $(urating).data("rating-value");
            $(urating).rating({
                readonly:true,
                value:ustars
            });
        })
    }
</script>
@endsection