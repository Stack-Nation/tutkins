@extends('layouts.authApp')
@section("title","Resume")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">{{$user->name}}'s Resume</h3>
            <a href="{{route("user.message",$user->id)}}" class="btn btn-light btn-sm" type="button"><i class="fa fa-comment"></i> Message</a>
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