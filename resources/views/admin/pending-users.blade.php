@extends('layouts.authApp')
@section("title","Admin Pending Users")
@section('content')
<!-- Content Header (Page header) -->	  
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">Pending User list</h3>
        </div>
        
    </div>
    <select name="role" class="custom-select mb-3 d-block" id="role" onchange="getType(this);">
        <option value="Users" @if($type==="User") selected @endif>All Users</option>
        <option value="Trainer" @if($type==="Trainer") selected @endif>Trainers</option>
        <option value="Organiser" @if($type==="Organiser") selected @endif>Organisers</option>
    </select>
</div>  

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="box">
              <div class="bootstrap-media row">
                @if($users->count()===0)
                <p>No user found.</p>
                @else
                @foreach ($users as $user)
                <div class="media align-items-center col-md-4">
                  <img class="img-fluid rounded" width="100px" height="100px" style="height: 100px;width:100px" src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" alt="...">

                  <div class="media-body ml-3">
                    <p>
                      <a href="#"><strong>{{$user->name}}</strong></a>
                    </p>
                    <p>{{$user->role}}</p>
                  </div>
                  <form action="{{route("admin.users.approve")}}" method="POST">
                      @csrf
                      <input type="hidden" name="id" value="{{$user->id}}">
                      <button class="btn btn-success btn-sm">Approve</button>
                  </form>
                  <form action="{{route("admin.users.deny")}}" method="POST">
                      @csrf
                      <input type="hidden" name="id" value="{{$user->id}}">
                      <button class="btn btn-danger btn-sm">Deny</button>
                  </form>
                </div>
                <hr/>
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