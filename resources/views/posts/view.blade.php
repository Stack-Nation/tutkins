@extends('layouts.courseApp')
@section('head')
<style>
    #user{
        color: gray;
        font-weight: bold;
        font-size: 1.6em;
    }
    .social{
        font-size: 3em;
        margin-right: 0.2em;
    }
    #msg{
        background: #EBEDF0;
        font-size:1.5em;
        color: black;
    }
</style>
@endsection
@section("title",$post->title)
@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <div class="page-separator">
                        <div class="page-separator__text">{{$post->title}}</div>
                    </div>
                    
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
                                            @if($post->announcement===1) <i class="fa fa-bullhorn fa-sm ml-2"></i> @endif
                                            <p>{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</p>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="content-body d-block">
                                {!!$post->body!!}
                            </div>
                            <div class="content-footer">
                                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Footer buttons">
                                    @if($post->user_id === Auth::user()->id)
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <form action="{{route("posts.delete")}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$post->id}}">
                                            <button class="btn btn-outline-danger"><i class="fa fa-trash mr-2"></i> Delete Post</button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
								<div class="page-separator mt-2">
									<div class="page-separator__text">Comments</div>
								</div>
								<form action="{{route("posts.comment",$post->id)}}" class="mt-2 mb-3" method="post">
									@csrf
									<div class="form-group">
										<textarea name="comment" id="create-comment"></textarea>
									</div>
									<button class="btn btn-info mb-3">Comment</button>
								</form>
								@if($comments===NULL)
								<p>No comment yet.</p>
								@else
								@foreach ($comments as $comment)
								<?php $cuser = \App\Models\User::find($comment->user_id);?>
									<div class="card">
										<div class="card-body">
											<div class="content-head row">
												<div class="col-md-12">
													<div class="user-info float-left">
														<img src="@if($cuser->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$cuser->photo)}} @endif"
														width="40"
														alt="avatar"
														class="rounded-circle float-left">
														<span class="float-right ml-3 mt-1">
															<strong>{{$cuser->name}}</strong>
															<p>{{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</p>
														</span>
													</div>
												</div>
											</div>
											<div class="content-body d-block">
												{!!$comment->comment!!}
											</div>
										</div>
									</div>
								@endforeach
								@endif
								{{$comments->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script type="module">
ClassicEditor
    .create( document.querySelector( '#create-comment' ))
    .catch( error => {
        console.error( error );
    });
</script>
@endsection