@extends('layouts.app')
@section("title","Edit Group Settings")
@section('head')
<style>
.custom-control-label::before, 
.custom-control-label::after {
    width: 1.25rem;
    height: 1.25rem;
}
</style>
@endsection
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Group</h1>
    
    <div class="container page__container page-section">
        <div class="page-separator">
            <div class="page-separator__text">Edit Group Settings</div>
        </div>
        <form action="{{route("groups.settings",$group->id)}}" method="post">
            @csrf
            <div class="custom-control form-control-lg custom-switch">
                <input type="checkbox" name="settings[]" class="custom-control-input" value="post_app" id="post_app" @if($group->post_approval===1) checked @endif>
                <label class="custom-control-label" for="post_app">Post Approval</label>
            </div>
            <div class="custom-control form-control-lg custom-switch">
                <input type="checkbox" name="settings[]" class="custom-control-input" value="join_app" id="join_app" @if($group->join_approval===1) checked @endif>
                <label class="custom-control-label" for="join_app">Join Approval</label>
            </div>
            <div class="custom-control form-control-lg custom-switch">
                <input type="checkbox" name="settings[]" class="custom-control-input" value="private" id="private" @if($group->private===1) checked @endif>
                <label class="custom-control-label" for="private">Private</label>
            </div>
            <button class="btn btn-primary">Change</button>
        </form>

        @if($group->course_id===NULL)
            <form action="{{route("groups.delete")}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$group->id}}">
                <button class="btn btn-outline-danger mt-4">Delete Group</button>
            </form>
        @endif
    </div>
</div>
@endsection