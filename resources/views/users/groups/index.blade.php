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
            <div class="card-header">
                <a href="{{route("user.groups.create")}}" class="btn btn-primary">Create new group</a>
            </div>
            <div class="table-responsive">
                @if($groups->count()===0)
                <p>No group found.</p>
                @else
                <div class="list-group">
                    @foreach ($groups as $group)
                        <a href="{{route("groups.view",[$group->id,md5($group->name)])}}" class="list-group-item list-group-item-action">
                          <div class="d-flex justify-content-between" style="width:100%">
                            <h5 class="mb-1">{{$group->name}}</h5>
                            <small>{{\Carbon\Carbon::parse($group->created_at)->diffForHumans()}}</small>
                          </div>
                          <p class="mb-1">{{$group->category->name}}</p>
                          @if($group->course_id!==NULL) <p class="mb-1">Linked with {{$group->course->title}}</p> @endif
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$groups->links()}}

            </div>

        </div>

    </div>
</div>
@endsection