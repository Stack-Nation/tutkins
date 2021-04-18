<?php 
    $exists = \App\Models\GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id,"approved"=>1])->exists();
?>
@extends('layouts.groups')
@section('head')
<style>
    #dis{
        background: white;
    }
    #names{
        background: white;
        height: 7em;
        padding-left: 11em;
    }
    #name{
        color: black;
        font-weight: bold;
        font-size: 2.5em;
    }
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
@section("title",$group->name)
@section('content')
<div class="profile is_group bg-white rounded-2xl -mt-4">

    <div class="profiles_banner">
        <img @if(Auth::user()->id === $group->owner_id) onclick="document.getElementById('change-cover-inp').click()" style="cursor:pointer" @endif src="@if($group->cover===NULL) {{asset("assets/groups/cover/default.jpg")}} @else {{asset("assets/groups/cover/".$group->cover)}} @endif" alt="">
    </div>
    <div class="profiles_content">
        <div class="profile_avatar">
            <div class="profile_avatar_holder"> 
                <img @if(Auth::user()->id === $group->owner_id) onclick="document.getElementById('change-photo-inp').click()" style="cursor:pointer" @endif src="{{asset("assets/groups/photo/".$group->photo)}}" alt="">
            </div>
            <div class="icon_change_photo" hidden> <ion-icon name="camera" class="text-xl"></ion-icon> </div>
        </div>
        @if(Auth::user()->id === $group->owner_id)
        <form enctype="multipart/form-data" action="{{route("groups.change-cover",$group->id)}}" id="change-cover" method="post" style="display: none">
            @csrf
            <input type="file" id="change-cover-inp" onchange="document.getElementById('change-cover').submit()" name="cover" accept=".jpg,.jpeg,.png">
        </form>
        <form enctype="multipart/form-data" action="{{route("groups.change-photo",$group->id)}}" id="change-photo" method="post" style="display: none">
            @csrf
            <input type="file" id="change-photo-inp" onchange="document.getElementById('change-photo').submit()" name="photo" accept=".jpg,.jpeg,.png">
        </form>
        @endif
        <div class="profile_info">
            <h1> {{$group->name}} 
                @if (Auth::user()->id === $group->owner_id)
                <button class="ml-2 btn btn-default btn-sm btn-inline" data-toggle="modal" data-target="#nameModal"><i class="fa fa-edit fa-lg text-dark"></i></button>
                @endif </h1>
            <p> {{$group->private?"Private":"Public"}} group ·  {{\App\Models\GroupMember::where(["group_id"=>$group->id,"approved"=>1])->count()}} members</p>
        </div>
        @if (Auth::user()->id !== $group->owner_id and $group->course_id===NULL)
        <div class="flex items-center space-x-4">
            <a href="{{route("groups.join",$group->id)}}" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5">
                <ion-icon name="thumbs-up"></ion-icon>
                <span> @if($exists) Leave Group @elseif(\App\Models\GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id,"approved"=>0])->exists()) Cancel Joining Request @else Join Group @endif </span>
            </a>
        </div>
        @endif

    </div>

    <nav class="cd-secondary-nav border-t -mb-0.5 lg:pl-2">
        <ul>
            <li class="active"><a href="{{route("groups.view",[$group->id,md5($group->name)])}}"> Home</a></li>
            @if (Auth::user()->id === $group->owner_id)
            <li><a href="{{route("groups.settings.join-requests",$group->id)}}"> Pending Join Requests</a></li>
            <li><a href="{{route("groups.settings.post-approval",$group->id)}}"> Pending Posts</a></li>
            <li><a href="{{route("groups.settings",$group->id)}}"> Settings</a></li>
            @endif
        </ul>
    </nav>
</div>
                    
<div class="lg:flex lg:mt-8 mt-4 lg:space-x-8">
    <div class="lg:w-8/12 lg:px-14 space-y-7">
        @if($exists)
        <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 p-4">
            <div class="flex space-x-3">
                <img src="@if(Auth::user()->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".Auth::user()->photo)}} @endif" class="w-10 h-10 rounded-full">
                <form action="{{route("groups.post.create",$group->id)}}" method="post">
                    @csrf
                    <div class="form-group">
                        <textarea name="post" id="create-post"></textarea>
                    </div>
                    <button class="btn btn-info mb-3">Create Post</button>
                </form>
            </div>
        </div>
        @endif
        @if($group->private===1 and !$exists)
            <p>Join the group to see the posts</p>
        @else
            @if($posts->count()===0)
            <p>No post found</p>
            @else
            @foreach ($posts as $post)
            <?php
                $likes = 0;
                $lkey = -1;
                $post->likes = json_decode($post->likes);
                if($post->likes!==NULL){
                    foreach ($post->likes as $key => $like) {
                        $likes++;
                        if($like->user_id === Auth::user()->id){
                            $lkey = $key;
                        }
                    }
                }
                $post->comments = json_decode($post->comments);
            ?>
            <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 uk-animation-slide-bottom-small">

                <!-- post header-->
                <div class="flex justify-between items-center lg:p-4 p-2.5">
                    <div class="flex flex-1 items-center space-x-4">
                        <a href="#">
                            <img src="@if($post->user->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$post->user->photo)}} @endif" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                        </a>
                        <div class="flex-1 font-semibold capitalize">
                            <a href="#" class="text-black"> {{$post->user->name}} @if($post->announcement===1) <i class="fa fa-bullhorn fa-lg ml-2"></i> @endif </a>
                            <div class="text-gray-700 flex items-center space-x-2">{{\Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</div>
                        </div>
                    </div>
                    
                @if($post->user_id === Auth::user()->id or $group->owner_id === Auth::user()->id)
                <div>
                    <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                    <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                    uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                
                        <ul class="space-y-1">
                        @if($group->owner_id===Auth::user()->id)
                        <li> 
                            <form action="{{route("groups.post.announcement",$group->id)}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$post->id}}">
                                <button class="px-1 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800"><i class="fa fa-bullhorn fa-lg"></i> Make Announcement</button>
                            </form>
                        </li>
                        @endif
                        <li>
                            <hr class="-mx-2 my-2 dark:border-gray-800">
                        </li>
                        <li> 
                            <form action="{{route("groups.post.delete",$group->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$post->id}}">
                                <button class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600"><i class="uil-trash-alt mr-1"></i> Delete</button>
                            </form>
                        </li>
                        </ul>
                    
                    </div>
                </div>
                @endif
                </div>

                <div uk-lightbox class="px-4">
                    {!!$post->content!!}
                </div>
                
                @if($exists)
                <div class="p-4 space-y-3"> 
                
                    <div class="flex space-x-4 lg:font-bold">
                        <form action="{{route("groups.post.like",$group->id)}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$post->id}}">
                            <input type="hidden" name="key" value="{{$lkey}}">
                            <button class="flex items-center space-x-2">
                                <div class="p-2 rounded-full @if($lkey!==-1) bg-dark text-light @else text-black lg:bg-gray-100 @endif ">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                                    </svg>
                                </div>
                                <div> Like</div>
                            </button>
                        </form>
                        <a href="#" data-toggle="collapse" data-target="#commentBox{{$post->id}}" class="flex items-center space-x-2 flex-1 justify-end">
                            <div class="p-2 rounded-full text-black lg:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div> Comment</div>
                        </a>
                    </div>
                    <div class="flex items-center space-x-3 pt-2">
                        <div class="dark:text-gray-100">
                            {{$likes}} Like(s)
                        </div>
                    </div>

                    <div class="border-t py-4 space-y-4 dark:border-gray-600 collapse mt-2" id="commentBox{{$post->id}}">
                        <form action="{{route("groups.post.comment",$group->id)}}" class="mt-2 mb-3" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$post->id}}">
                            <div class="form-group">
                                <textarea name="comment" class="create-comment"></textarea>
                            </div>
                            <button class="btn btn-info mb-3">Comment</button>
                        </form>
                        @if($post->comments===NULL)
                        <p>No comment yet.</p>
                        @else
                        @foreach ($post->comments as $comment)
                        <?php $cuser = \App\Models\User::find($comment->user_id);?>
                            <div class="flex">
                                <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                    <img src="@if($cuser->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$cuser->photo)}} @endif" alt="" class="absolute h-full rounded-full w-full">
                                </div>
                                <div>
                                    <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                        {!!$comment->comment!!}
                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                    </div>
                                    <div class="text-sm flex items-center space-x-3 mt-2 ml-2">
                                        <span>By <strong>{{$cuser->name}}</strong></span>
                                        <span> {{\Carbon\Carbon::parse($comment->created_at)->diffForHumans()}} </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                @endif

            </div>
            @endforeach
            @endif
        @endif

    
    </div>
    <div class="lg:w-4/12 flex-shirink-0">

        <div class="bg-white rounded-md shadow-sm border p-5">

            <h1 class="block text-xl font-bold"> About  </h1>

            <div class="space-y-4 mt-3">
                
                <div class="items-center space-x-3">
                    <div class="flex-1">
                        @if(Auth::user()->id===$group->owner_id)
                        <button class="float-right btn btn-default btn-sm" data-toggle="modal" data-target="#descriptionModal"><i class="fa fa-edit fa-lg"></i></button>
                        @endif
                        @if($group->description==NULL)
                            <p>No description available.</p>
                        @else
                            <div class="text-truncate" id="content" data-expand="0" style="height:50px">
                                {!!$group->description!!}
                            </div>
                            <button class="btn btn-link" id="readm" onclick="readMore();">Read More</button>
                        @endif
                    </div>
                </div> 
                <div class="flex items-center space-x-3">
                    <ion-icon name="thumbs-up" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                    <div class="flex-1">
                        <div class="font-semibold">  {{\App\Models\GroupMember::where(["group_id"=>$group->id,"approved"=>1])->count()}} members </div>
                    </div>
                </div> 
                <div class="flex items-center space-x-3">
                    <ion-icon name="globe" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                    <div class="flex-1">
                        <div> Created By: {{$group->owner->name}} </div> 
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <ion-icon name="mail-open" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                    <div class="flex-1">
                        <div> Category: {{$group->category->name}} </div> 
                    </div>
                </div>
                 
            </div>
            

        </div>

    </div>
</div>
{{-- <!-- Banner Area Start -->
<div class="banner-user banner-user-group" id="cover">
    <div class="banner-content">
        <div class="media">
            <div class="item-img">
                <img  src="" width="110px" alt="User">
            </div>
            <div class="media-body">
                <h3 class="item-title"></h3>
                @if (Auth::user()->id === $group->owner_id)
                <button class="ml-2 btn btn-default btn-sm" data-toggle="modal" data-target="#nameModal"><i class="fa fa-edit fa-lg text-light"></i></button>
                @endif
                <div class="item-subtitle">
                    <a id="msg" class="btn btn-default btn-sm" style="height:35px;font-size:20px" role="button" href=""></a>
                </div>
                <div class="item-social">
                    @if(Auth::user()->id === $group->owner_id)
                    <button class="mt-4 btn btn-light mr-1" style="display:none" onclick="" id="change-cover-btn">Change Cover</button>
                    @endif
                </div>
                <ul class="user-meta">
                    <li>Group Type: <span>{{$group->private?"Private":"Public"}}</span></li>
                    <li>Posts: <span>{{$group->posts->count()}}</span></li>
                    <li>Members: <span></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        @if($group->private===1 and !$exists)
            <p>Join the group to see the posts</p>
        @else
            @if($posts->count()===0)
            <p>No post found</p>
            @else
            @foreach ($posts as $post)
            <div class="block-box post-view">
                <div class="post-body">
                    
                    <div class="post-meta-wrap">
                        <div class="post-meta">
                            <div class="meta-text">{{$likes}} Like(s)</div>
                        </div>
                        <div class="post-meta">
                            <div class="meta-text">{{$post->comments===NULL? 0: count($post->comments)}} Comments</div>
                        </div>
                    </div>
                </div>
                <div class="post-footer">
                    <ul>
                        <li class="post-react">
                        </li>
                        <li><a href="#" ><i class="icofont-comment"></i>Comment</a></li>
                    </ul>
                    
                    <div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="content-head row">
                                        <div class="col-md-12">
                                            <div class="user-info float-left">
                                                <img src=""
                                                width="40"
                                                alt="avatar"
                                                class="rounded-circle float-left">
                                                <span class="float-right ml-3 mt-1">
                                                    <strong></strong>
                                                    <p></p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-body d-block">
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            {{$posts->links()}}
        @endif
    </div>
</div> --}}
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(document).mousemove(function(){
            if($("#cover:hover").length != 0){
                $("#change-cover-btn").css("display","inline");
            } else{
                $("#change-cover-btn").css("display","none");
            }
        });
    });
    function readMore(){
        const expand = $("#content").data("expand");
        if(expand==0){
            $("#readm").html("Read Less");
            $("#content").removeClass("text-truncate");
            $("#content").css("height","100%");
            $("#content").data("expand",1);
        }
        else{
            $("#readm").html("Read More");
            $("#content").addClass("text-truncate");
            $("#content").css("height","50px");
            $("#content").data("expand",0);
        }
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script type="module">
ClassicEditor
    .create( document.querySelector( '#change-description' ))
    .catch( error => {
        console.error( error );
    });
ClassicEditor
    .create( document.querySelector( '#create-post' ))
    .catch( error => {
        console.error( error );
    });
const comments = $(".create-comment");
comments.map((key,comment)=>{
    ClassicEditor
        .create(comment)
        .catch( error => {
            console.error( error );
        });
})
</script>
@endsection
@section('modals')
@if(Auth::user()->id===$group->owner_id)
<!-- Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="descriptionModalLabel">Change description</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('groups.change-description',$group->id) }}">
                @csrf
                <div class="form-group">
                    <textarea name="description" id="change-description">{{$group->description}}</textarea>
                </div>
                <button class="btn btn-primary">Change</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
    <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="nameModalLabel">Change name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('groups.change-name',$group->id) }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" class="form-control" value="{{$group->name}}">
                </div>
                <button class="btn btn-primary">Change</button>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endif
@endsection