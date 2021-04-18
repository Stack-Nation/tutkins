@extends('layouts.authApp')
@section("title","Your Groups")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Groups</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">All Groups</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($members->count()===0)
                <p>You haven't joined any group yet.</p>
                @else
                <div class="list-group">
                    @foreach ($members as $member)
                        <a href="{{route("groups.view",[$member->group->id,md5($member->group->name)])}}" class="list-group-item list-group-item-action">
                          <div class="d-flex justify-content-between" style="width: 100%">
                            <h5 class="mb-1">{{$member->group->name}}</h5>
                            <small>Joined: {{\Carbon\Carbon::parse($member->group->created_at)->diffForHumans()}}</small>
                          </div>
                          <p class="mb-1">{{$member->group->category->name}}</p>
                          @if($member->group->course_id!==NULL) <p class="mb-1">Linked with {{$member->group->course->title}}</p> @endif
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$members->links()}}

            </div>

        </div>

    </div>
</div>
@endsection