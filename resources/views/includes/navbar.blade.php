        <div class="header" style="margin-left: 0;width:100%;">    
            <div class="header-content">
                <div class="header-left">
                    <ul>
                        <li class="icons @if(Request::route()->getName()=="home") active @endif">
                            <a href="{{route("home")}}" class="nav-link">Home</a>
                        </li>
                        <li class="icons @if(Request::route()->getName()=="programs.index") active @endif">
                            <a href="{{route("programs.index")}}" class="nav-link">Programs</a>
                        </li>
                        <li class="icons @if(Request::route()->getName()=="events.index") active @endif">
                            <a href="{{route("events.index")}}" class="nav-link">Events</a>
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
                                @if(Auth::user()->role==="Kid")
                                <a class="dropdown-item" href="{{route("kid.dashboard")}}">
                                    Kid Dashboard
                                </a>
                                @endif
                                @if(Auth::user()->role==="Trainer")
                                <a class="dropdown-item" href="{{route("trainer.dashboard")}}">
                                    Trainer Dashboard
                                </a>
                                @endif
                                @if(Auth::user()->role==="Manager")
                                <a class="dropdown-item" href="{{route("manager.dashboard")}}">
                                    Manager Dashboard
                                </a>
                                @endif
                                @if(Auth::user()->role==="Organiser")
                                <a class="dropdown-item" href="{{route("organiser.dashboard")}}">
                                    Organiser Dashboard
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