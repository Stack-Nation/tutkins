<?php
    $notifications = \App\Models\Notification::where("user_id",Auth::user()->id)->latest()->take(10)->get();
?>
  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">
		<a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
			<span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
		</a>	
		<!-- Logo -->
		<a href="{{route("home")}}" class="logo">
		  <!-- logo-->
		  <div class="logo-lg">
			  <span class="light-logo"><img src="{{asset("assets/main/images/logo.png")}}" alt="logo"></span>
			  <span class="dark-logo"><img src="{{asset("assets/main/images/logo.png")}}" alt="logo"></span>
		  </div>
		</a>	
	</div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div class="app-menu">
		<ul class="header-megamenu nav">
            <li class="btn-group nav-item @if(Request::route()->getName()=="home") active @endif">
                <a href="{{route("home")}}"
                    class="nav-link">Home</a>
            </li>
            <li class="btn-group nav-item @if(Request::route()->getName()=="courses.index") active @endif">
                <a href="{{route("courses.index")}}" class="nav-link">Courses</a>
            </li>
            <li class="btn-group nav-item @if(Request::route()->getName()=="groups.index") active @endif">
                <a href="{{route("groups.index")}}" class="nav-link">Groups</a>
            </li>
            <li class="btn-group nav-item @if(Request::route()->getName()=="webinars.index") active @endif">
                <a href="{{route("webinars.index")}}" class="nav-link">Webinars</a>
            </li>
            <li class="btn-group nav-item @if(Request::route()->getName()=="mentorings.index") active @endif">
                <a href="{{route("mentorings.index")}}" class="nav-link">Mentoring Programs</a>
            </li>
		</ul> 
	  </div>
		
      <div class="navbar-custom-menu r-side">
        <ul class=" nav navbar-nav">
            <!-- Notifications -->
            <li class="dropdown notifications-menu">
              <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown" title="Notifications">
                <i class="icon-Notifications"><span class="path1"></span><span class="path2"></span></i>
              </a>
              <ul class="dropdown-menu animated bounceIn">
  
                <li class="header">
                  <div class="p-20">
                      <div class="flexbox">
                          <div>
                              <h4 class="mb-0 mt-0">Notifications</h4>
                          </div>
                      </div>
                  </div>
                </li>
  
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu sm-scrol">
                    @if($notifications->count()>0)
                    @foreach($notifications as $notification)
                    <li>
                      <a href="#!">
                        {!!$notification->message!!}
                      </a>
                    </li>
                    @endforeach
                    @else
                    <li><a href="#!">No notification found.</a></li>
                    @endif
                  </ul>
                </li>
              </ul>
            </li>	
          @guest
          <li class="nav-item">
              <a href="{{route("getting-started")}}" class="btn btn-outline-dark">Get Started</a>
          </li>
          @endguest
          @auth
          <li class="nav-item @if(Request::route()->getName()==="user.*") active @endif dropdown  notifications-menu">
              <a id="navbarDropdown" class="waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
			    <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" uk-dropdown="pos: top-right ;mode:click" class="dropdown-notifications small">
                  @if(Auth::user()->role==="Admin")
                  <a class="dropdown-item text-dark" href="{{route("admin.dashboard")}}">
                      Admin Dashboard
                  </a>
                  @endif
                  @if(Auth::user()->role==="Instructor")
                  <a class="dropdown-item text-dark" href="{{route("instructor.dashboard")}}">
                      Instructor Dashboard
                  </a>
                  @endif
                  @if(Auth::user()->role==="Mentee")
                  <a class="dropdown-item text-dark" href="{{route("mentee.dashboard")}}">
                      Mentee Dashboard
                  </a>
                  @endif
                  @if(Auth::user()->role==="Manager")
                  <a class="dropdown-item text-dark" href="{{route("manager.dashboard")}}">
                      Manager Dashboard
                  </a>
                  @endif
                  @if(Auth::user()->role==="Organisation")
                  <a class="dropdown-item text-dark" href="{{route("organisation.dashboard")}}">
                      Organisation Dashboard
                  </a>
                  @endif
                  @if(Auth::user()->role==="Institution")
                  <a class="dropdown-item text-dark" href="{{route("institution.dashboard")}}">
                      Institution Dashboard
                  </a>
                  @endif
                  <a class="dropdown-item text-dark" href="{{route("user.settings")}}">
                      Settings
                  </a>
                  <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </div>
          </li>
          @endauth
        </ul>
      </div>
    </nav>
  </header>