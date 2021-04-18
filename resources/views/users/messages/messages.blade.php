<?php
    $enc = array();
?>
@extends('layouts.authApp')
@section("title","Messages")
@section('head')
<style>
  [contenteditable=true]:empty:before{
    content: attr(placeholder);
    pointer-events: none;
    display: block; /* For Firefox */
  }
  .file-msg{
    color:red;
    text-decoration: underline;
  }
  .img-msg-img{
    height:100px;
    width:100px;
  }
</style>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        @if($receiver==NULL)
        <p>No conversations found.</p>
        @else
        <div class="col-lg-3 col-12">
            <div class="box">
                <div class="box-body">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="messages" role="tabpanel">
                            <div class="chat-box-one-side3">
                                <div class="media-list media-list-hover">
                                  @foreach($chats as $c)
                                    @if(in_array($c->sender_id,$enc) or in_array($c->receiver_id,$enc))
                                        <?php continue; ?>
                                    @else
                                    <?php 
                                        if($c->sender_id==Auth::user()->id){
                                            array_push($enc,$c->receiver_id);
                                            $uid = $c->receiver_id;
                                        }
                                        else{
                                            array_push($enc,$c->sender_id);
                                            $uid = $c->sender_id;
                                        }
                                        $user = DB::table('users')->find($uid);
                                    ?>
                                    <div class="media @if($user->id===$receiver->id) active @endif">
                                      <a class="align-self-center mr-0" href="#"><img class="avatar avatar-lg" src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" alt="..."></a>
                                      <div class="media-body">
                                        <p>
                                          <a class="hover-primary" href="#"><strong>{{$user->name}}</strong></a>
                                          <span class="float-left font-size-10">{{\Carbon\Carbon::parse($c->created_at)->diffForHumans()}}</span>
                                        </p>
                                      </div>
                                    </div>
                                    @endif
                                  @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="row">
                <div class="col-xxxl-8 col-lg-7 col-12">
                    <div class="box bg-lightest">
                      <div class="box-header">
                        <div class="media align-items-top p-0">
                          <a class="avatar avatar-lg status-success mx-0" href="#">
                            <img src="{{asset("assets/users/photo/".($receiver->photo??"default.png"))}}" class="rounded-circle" alt="...">
                          </a>
                            <div class="d-lg-flex d-block justify-content-between align-items-center w-p100">
                                <div class="media-body mb-lg-0 mb-20">
                                    <p class="font-size-16">
                                      <a class="hover-primary" href="#"><strong>{{$receiver->name}}</strong></a>
                                    </p>
                                </div>
                            </div>				  
                        </div>             
                      </div>
                      <div class="box-body">
                          <div class="chat-box-one2" id="message-area">
                            @foreach($messages as $message)
                              <div class="card d-inline-block mb-3 mr-2 @if($message->sender_id === Auth::user()->id) bg-primary float-right @else no-shadow bg-lighter float-left @endif max-w-p80" style="min-width:200px">
                                <div class="position-absolute pt-1 pr-2 r-0">
                                    <span class="text-extra-small">{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</span>
                                </div>
                                <div class="card-body">
                                    <div class="chat-text-left pl-55">
                                      {!!$message->message!!}
                                    </div>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                            @endforeach
                          </div>
                      </div>
                      <div class="box-footer no-border">
                         <div class="d-md-flex d-block justify-content-between align-items-center bg-white p-5 rounded20 b-1 overflow-hidden">
                                <div class="py-10 b-0 form-control" id="messagebar" style="max-width:100%;overflow:auto" placeholder="Say something..." contenteditable="true"></div>
                                <textarea name="message" id="message" hidden></textarea>
                                <div class="d-flex justify-content-between align-items-center mt-md-0 mt-30">
                                  <form action="{{route("user.sendFile")}}" method="POST" id="fileForm" hidden enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="messageFile" id="messageFile" hidden>
                                  </form>
                                  <button type="button" class="waves-effect waves-circle btn btn-circle mr-10 btn-outline-secondary" onclick="document.getElementById('messageFile').click()">
                                      <i class="mdi mdi-link"></i>
                                  </button>
                                  <form action="{{route("user.sendImage")}}" method="POST" id="imageForm" hidden enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="messageImage" id="messageImage" accept=".png,.jpg,.jpeg,.gif,.bmp" hidden>
                                  </form>
                                    <button type="button" class="waves-effect waves-circle btn btn-circle mr-10 btn-outline-secondary" onclick="document.getElementById('messageImage').click()">
                                        <i class="mdi mdi-image"></i>
                                    </button>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</section>
<!-- /.content -->
<form action="{{route("user.sendMessage")}}" id="messageForm" style="hidden">@csrf</form>
@endsection
@section('modals')
<div class="modal fade" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="view-img-modal">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
@if($receiver!==NULL)
<script>
  localStorage.setItem("receiver","{{$receiver->id}}")
  localStorage.setItem("display_message_route","{{route('user.messagesA')}}")
  localStorage.setItem("user_image","{{asset('assets/users/photo/')}}")
</script>
<script src="{{asset("assets/users/js/message.js")}}"></script>
@endif
@endsection