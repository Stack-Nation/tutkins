@extends('layouts.authApp')
@section("title","Resume")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">Resume</h3>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-12">
        <div class="box">
          <div class="box-header">
            <h4 class="box-title mr-4">Experience</h4>
            <button class="btn btn-info btn-sm ml-4" data-toggle="modal" data-target="#expModal"><i class="fa fa-plus"></i> Add</button>
          </div>
          <div class="box-body">
              @if($user->experiences===NULL)
              <p>No experience added</p>
              @else
              <div class="row">
              @foreach ($user->experiences as $experience)
              <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Company Name</strong>: {{$experience->company}}</p>
                        <p><strong>Description</strong>: {{$experience->description}}</p>
                        <p><strong>Position</strong>: {{$experience->position}}</p>
                        <p><strong>Duration</strong>: {{$experience->start}} - {{$experience->end}}</p>
                    </div>
                </div>
              </div>
              @endforeach
              </div>
              @endif
          </div>
        </div>
        <div class="box">
          <div class="box-header">
            <h4 class="box-title mr-4">Skills</h4>
            <button class="btn btn-info btn-sm ml-4" data-toggle="modal" data-target="#skillModal"><i class="fa fa-plus"></i> Add</button>
          </div>
          <div class="box-body">
              @if($user->skills===NULL)
              <p>No skill added</p>
              @else
              <div class="row">
              @foreach ($user->skills as $skill)
              <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Skill Name</strong>: {{$skill->name}}</p>
                        <p><strong>Score</strong>: {{$skill->score}}</p>
                    </div>
                </div>
              </div>
              @endforeach
              </div>
              @endif
          </div>
        </div>
        <div class="box">
          <div class="box-header">
            <h4 class="box-title mr-4">Projects</h4>
            <button class="btn btn-info btn-sm ml-4" data-toggle="modal" data-target="#projectModal"><i class="fa fa-plus"></i> Add</button>
          </div>
          <div class="box-body">
            <div class="box-body">
                @if($user->projects===NULL)
                <p>No project added</p>
                @else
                <div class="row">
                @foreach ($user->projects as $project)
                <div class="col-md-4">
                  <div class="card">
                      <div class="card-body">
                          <p><strong>Project Name</strong>: {{$project->name}}</p>
                          <p><strong>Description</strong>: {{$project->description}}</p>
                          <p><strong>Duration</strong>: {{$project->start}} - {{$project->end}}</p>
                      </div>
                  </div>
                </div>
                @endforeach
                </div>
                @endif
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-header">
            <h4 class="box-title mr-4">Achievements</h4>
            <button class="btn btn-info btn-sm ml-4" data-toggle="modal" data-target="#achModal"><i class="fa fa-plus"></i> Add</button>
          </div>
          <div class="box-body">
            <div class="box-body">
                @if($user->achievements===NULL)
                <p>No achievement added</p>
                @else
                <div class="row">
                @foreach ($user->achievements as $achievement)
                <div class="col-md-4">
                  <div class="card">
                      <div class="card-body">
                          <p><strong>Achievement Title</strong>: {{$achievement->title}}</p>
                          <p><strong>Description</strong>: {{$achievement->description}}</p>
                      </div>
                  </div>
                </div>
                @endforeach
                </div>
                @endif
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-header">
            <h4 class="box-title mr-4">Social</h4>
            <button class="btn btn-info btn-sm ml-4" data-toggle="modal" data-target="#socialModal"><i class="fa fa-plus"></i> Add</button>
          </div>
          <div class="box-body">
              @if($user->social===NULL)
              <p>No social links added.</p>
              @else
              @foreach($user->social as $social)
              @if($social->link!==NULL)
                <a href="{{$social->link}}" class="btn btn-dark"><i class="{{$social->icon}} fa-2x"></i></a>
              @endif
              @endforeach
              @endif
          </div>
        </div>
    </div>
</div>

</section>
<!-- /.content -->
@endsection
@section("modals")
{{-- Experience Modal --}}
<div class="modal fade" id="expModal" tabindex="-1" aria-labelledby="expLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Experience</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{route("user.experience")}}" method="post">
            @csrf
            <div class="form-group mb-2">
                <input type="text" name="company" placeholder="Company Name" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="description" placeholder="Description" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="position" placeholder="Position" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="start" placeholder="Start Date" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="end" placeholder="End Date" id="endexp" class="form-control mb-1">
                <input type="checkbox" id="curexp" onchange="document.getElementById('endexp').value='Currently Here'"><label for="curexp">Currently Here</label>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Skill Modal --}}
<div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Skill</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route("user.skill")}}" method="post">
          @csrf
          <div class="form-group mb-2">
              <input type="text" name="name" placeholder="Skill Name" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="range" name="score" placeholder="Score" min="0" max="5" value="0" onchange="document.getElementById('sct').innerText=this.value" class="form-control">
              <span id="sct">0</span>
          </div>
          <button type="submit" class="btn btn-success">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Project Modal --}}
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Project</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route("user.project")}}" method="post">
          @csrf
          <div class="form-group mb-2">
              <input type="text" name="name" placeholder="Project Name" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="description" placeholder="Description" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="start" placeholder="Start Date" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="end" placeholder="End Date" id="endproj" class="form-control mb-1">
              <input type="checkbox" id="curproj" onchange="document.getElementById('endproj').value='Currently Working'"><label for="curproj">Currently Working</label>
          </div>
          <button type="submit" class="btn btn-success">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Achievement Modal --}}
<div class="modal fade" id="achModal" tabindex="-1" aria-labelledby="achLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Achievement</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route("user.achievement")}}" method="post">
          @csrf
          <div class="form-group mb-2">
              <input type="text" name="title" placeholder="Title" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="description" placeholder="Description" class="form-control">
          </div>
          <button type="submit" class="btn btn-success">Add</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- Social Modal --}}
<div class="modal fade" id="socialModal" tabindex="-1" aria-labelledby="socialLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Social</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route("user.social")}}" method="post">
          @csrf
          <div class="form-group mb-2">
              <input type="text" name="facebook" @if($user->social!==NULL) value="{{$user->social["facebook"]->link}}" @endif placeholder="Facebook" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="twitter" @if($user->social!==NULL) value="{{$user->social["twitter"]->link}}" @endif placeholder="Twitter" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="instagram" @if($user->social!==NULL) value="{{$user->social["instagram"]->link}}" @endif placeholder="Instagram" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="linkedin" @if($user->social!==NULL) value="{{$user->social["linkedin"]->link}}" @endif placeholder="Linkedin" class="form-control">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="github" @if($user->social!==NULL) value="{{$user->social["github"]->link}}" @endif placeholder="Github" class="form-control mb-1">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="youtube" @if($user->social!==NULL) value="{{$user->social["youtube"]->link}}" @endif placeholder="Youtube" class="form-control mb-1">
          </div>
          <div class="form-group mb-2">
              <input type="text" name="website" @if($user->social!==NULL) value="{{$user->social["website"]->link}}" @endif placeholder="Website" class="form-control mb-1">
          </div>
          <button type="submit" class="btn btn-success">Update</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection