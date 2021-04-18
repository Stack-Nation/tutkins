@extends('layouts.app')
@section("title","Joining Requests")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Requests</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Joining Requests</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($members->count()===0)
                <p>No joining request found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($members as $member)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$member->user->name}}</td>
                                <td>
                                    <form action="{{route("groups.settings.join-requests.approve",$member->group_id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$member->id}}">
                                        <button class="btn btn-success"><i class="fa fa-check"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route("groups.settings.join-requests.reject",$member->group_id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$member->id}}">
                                        <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$members->links()}}

            </div>

        </div>

    </div>
</div>
@endsection