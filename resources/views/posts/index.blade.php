@extends('layouts.courseApp')
@section("title",$forum->name)
@section('content')
<div class="page-section">
    <div class="container page__container">

        <div class="page-separator">
            <div class="page-separator__text">All Posts</div>
        </div>
        <a href="{{route("posts.create",[$forum->id,md5($forum->name)])}}" class="btn btn-primary mb-3">Create Post</a>
        @if($posts->count()===0)
        <p>No post found</p>
        @else
        <div class="list-group">
            @foreach ($posts as $post)
            <a href="{{route("posts.view",[$post->id,md5($post->title)])}}" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between" style="width: 100%">
                <h5 class="mb-1">{{$post->title}}</h5>
                <small>{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</small>
                </div>
                <p class="mb-1">By {{$post->user->name}}</p>
            </a>
            @endforeach
        </div>
        @endif
        {{$posts->links()}}

    </div>
</div>
@endsection