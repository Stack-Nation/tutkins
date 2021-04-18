@extends('layouts.authApp')
@section("title","Admin Users")
@section('content')
<!-- Content Header (Page header) -->	  
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">User list</h3>
        </div>
        
    </div>
    <select name="role" class="custom-select mb-3 d-block" id="role" onchange="getType(this);">
        <option value="Users" @if($type==="User") selected @endif>All Users</option>
        <option value="Admin" @if($type==="Admin") selected @endif>Admins</option>
        <option value="Instructor" @if($type==="Instructor") selected @endif>Instructors</option>
        <option value="Mentee" @if($type==="Mentee") selected @endif>Mentees</option>
        <option value="Institution" @if($type==="Institution") selected @endif>Institutions</option>
        <option value="Organization" @if($type==="Organization") selected @endif>Organizations</option>
    </select>
</div>  

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="box">
              <div class="media-list media-list-divided media-list-hover">
                @if($users->count()===0)
                <p>No user found.</p>
                @else
                @foreach ($users as $user)
                <div class="media align-items-center">
                  <span class="badge badge-dot badge-danger"></span>
                  <a class="avatar avatar-lg status-success" href="#">
                    <img src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" alt="...">
                  </a>

                  <div class="media-body">
                    <p>
                      <a href="#"><strong>{{$user->name}}</strong></a>
                    </p>
                    <p>{{$user->role}}</p>
                  </div>
                </div>
                @endforeach
                @endif
              </div>
            </div>
            {{$users->links()}}
        </div>				
    </div>
</section>
<!-- /.content -->
@endsection
@section('scripts')
<script>
    function getType(obj){
        const val = $(obj).val();
        if(val==="Users"){
            location.href = "{{route('admin.users')}}"
        }
        else{
            location.href = `{{route('admin.users')}}/${val}`
        }
    }
</script>
@endsection