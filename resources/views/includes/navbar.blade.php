        <div class="header" style="margin-left: 0;width:100%;">    
            <div class="header-content">
                <div class="header-left">
                    <ul>
                        <li class="icons @if(Request::route()->getName()=="home") active @endif">
                            <a href="{{route("home")}}"
                                class="nav-link">Home</a>
                        </li>
                    </ul>
                </div>
                <div class="header-right">
                    <ul>
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
            </div>
        </div>