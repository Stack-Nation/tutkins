
            <div class="navbar navbar-expand navbar-light border-bottom-2" id="default-navbar" data-primary>

               <!-- Navbar toggler -->
               <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
                   <span class="material-icons">short_text</span>
               </button>

               <!-- Navbar Brand -->
               <a href="{{route("home")}}" class="navbar-brand mr-16pt d-lg-none">
                   <!-- <img class="navbar-brand-icon" src="../../public/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                   <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                       <span class="avatar-title rounded bg-primary"><img src="{{asset("assets/main/images/logo.png")}}"
                                alt="logo"
                                class="img-fluid" /></span>

                   </span>

                   <span class="d-none d-lg-block">{{config("app.name")}}</span>
               </a>
                <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                    <li class="nav-item @if(Request::route()->getName()=="home") active @endif">
                        <a href="{{route("home")}}"
                            class="nav-link">Home</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName()=="courses.index") active @endif">
                        <a href="{{route("courses.index")}}" class="nav-link">Courses</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName()=="groups.index") active @endif">
                        <a href="{{route("groups.index")}}" class="nav-link">Groups</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName()=="webinars.index") active @endif">
                        <a href="{{route("webinars.index")}}" class="nav-link">Webinars</a>
                    </li>
                    <li class="nav-item @if(Request::route()->getName()=="mentorings.index") active @endif">
                        <a href="{{route("mentorings.index")}}" class="nav-link">Mentoring Programs</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav ml-auto mr-0">
                    @guest
                    <li class="nav-item">
                        <a href="{{route("getting-started")}}" class="btn btn-outline-dark">Get Started</a>
                    </li>
                    @endguest
                    @auth
                    <li class="nav-item @if(Request::route()->getName()==="user.*") active @endif dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role==="Admin")
                            <a class="dropdown-item" href="{{route("admin.dashboard")}}">
                                Admin Dashboard
                            </a>
                            @endif
                            @if(Auth::user()->role==="Instructor")
                            <a class="dropdown-item" href="{{route("instructor.dashboard")}}">
                                Instructor Dashboard
                            </a>
                            @endif
                            @if(Auth::user()->role==="Mentee")
                            <a class="dropdown-item" href="{{route("mentee.dashboard")}}">
                                Mentee Dashboard
                            </a>
                            @endif
                            @if(Auth::user()->role==="Manager")
                            <a class="dropdown-item" href="{{route("manager.dashboard")}}">
                                Manager Dashboard
                            </a>
                            @endif
                            @if(Auth::user()->role==="Organisation")
                            <a class="dropdown-item" href="{{route("organisation.dashboard")}}">
                                Organisation Dashboard
                            </a>
                            @endif
                            @if(Auth::user()->role==="Institution")
                            <a class="dropdown-item" href="{{route("institution.dashboard")}}">
                                Institution Dashboard
                            </a>
                            @endif
                            <a class="dropdown-item" href="{{route("user.settings")}}">
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
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