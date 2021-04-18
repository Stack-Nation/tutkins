@extends('layouts.app')
@section("title","Post Approval")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Posts</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Post Approval</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($posts->count()===0)
                <p>No pending posts found.</p>
                @else
                    @foreach ($posts as $post)
                    <div class="card">
                        <div class="card-body">
                            <div class="content-head row">
                                <div class="col-md-12">
                                    <div class="user-info float-left">
                                        <img src="@if($post->user->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$post->user->photo)}} @endif"
                                        width="40"
                                        alt="avatar"
                                        class="rounded-circle float-left">
                                        <span class="float-right ml-3 mt-1">
                                            <strong>{{$post->user->name}}</strong>
                                            <p>{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="content-body d-block">
                                {!!$post->content!!}
                            </div>
                            <div class="content-footer">
                                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Footer buttons">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <form action="{{route("groups.settings.post-approval.approve",$post->group_id)}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$post->id}}">
                                            <button class="btn btn-success">Approve</button>
                                        </form>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <form action="{{route("groups.settings.post-approval.reject",$post->group_id)}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$post->id}}">
                                            <button class="btn btn-danger">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$posts->links()}}

            </div>

        </div>

    </div>
</div>
@endsection