<nav class="navbar navbar-expand-lg navbar-light" style="background: #FFFFFF">
    <a class="navbar-brand" href="{{route("home")}}">{{config("app.name")}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
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
      <ul class="navbar-nav ml-auto">
        @guest
        <li class="nav-item">
            <a href="{{route("getting-started")}}" class="btn btn-outline-dark">Get Started</a>
        </li>
        @endguest
        @auth
        <li class="nav-item @if(Request::route()->getName()==="user.*") active @endif dropdown">
            <a id="navbarDropdown" class="nav-link  header-widget-icon profile-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
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