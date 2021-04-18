@extends('layouts.groups')
@section("title","Groups")
@section('content')
<div class="flex justify-between relative md:mb-4 mb-3">
    <div class="flex-1">
        <h2 class="text-3xl font-semibold"> Groups </h2>
    </div>
</div>
<div class="relative" uk-slider="finite: true">

    <div class="row gutters-20">
        @if($groups->count()===0)
        <p>No group found</p>
        @else
            @foreach($groups as $group)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-media h-28">
                            <div class="card-media-overly"></div>
                            <img src="@if($group->cover===NULL) {{asset("assets/groups/cover/default.jpg")}} @else {{asset("assets/groups/cover/".$group->cover)}} @endif" alt="" class="">
                        </div>
                        <div class="card-body">
                            <a href="{{route("groups.view",[$group->id,md5($group->name)])}}" class="font-semibold text-lg truncate"> {{$group->name}} </a>
                            <div class="flex items-center flex-wrap space-x-1 text-sm text-gray-500 capitalize">
                                <a href="#"> <span> {{\App\Models\GroupMember::where(["group_id"=>$group->id,"approved"=>1])->count()}} members </span> </a>
                                <a href="#"> <span> {{$group->posts->count()}} posts </span> </a>
                            </div> 
    
                            <div class="flex mt-3 space-x-2 text-sm">
                                <a href="{{route("groups.view",[$group->id,md5($group->name)])}}" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize"> 
                                    Join 
                                </a>
                                <a href="{{route("groups.view",[$group->id,md5($group->name)])}}" class="bg-gray-200 flex flex-1 h-8 items-center justify-center rounded-md capitalize"> 
                                    View 
                                </a>
                            </div>    
    
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="pagination">
        {{$groups->links()}}
    </div>
</div>
@endsection