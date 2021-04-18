<ul class="nav nav-pills mb-3">
    <li class="nav-item">
      <a class="nav-link @if(Request::route()->getName()==="instructor.courses.edit-land") active @endif" href="{{route("instructor.courses.edit-land",$course->id)}}">Course Landing</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if(Request::route()->getName()==="instructor.courses.edit-target") active @endif" href="{{route("instructor.courses.edit-target",$course->id)}}">Course Targets</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if(Request::route()->getName()==="instructor.courses.edit-cir") active @endif" href="{{route("instructor.courses.edit-cir",$course->id)}}">Course Curriculum</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @if(Request::route()->getName()==="instructor.courses.edit-settings") active @endif" href="{{route("instructor.courses.edit-settings",$course->id)}}">Course Settings</a>
    </li>
</ul>