@extends('layouts.authApp')
@section("title","Program Subscribers")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Subscribers</h2>
            </div>
            <div class="card-body">
                @if($subscribers->count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Slot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td><a href="{{route("kid.view-profile",$subscriber->user->id)}}">{{$subscriber->user->name}}</a></td>
                                <td>{{$subscriber->user->email}}</td>
                                <td>{{$subscriber->type}}</td>
                                <td>{{\Carbon\Carbon::parse($subscriber->date)->format("d M Y")}} at {{\Carbon\Carbon::parse($subscriber->time)->format("h:i:s A")}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-dark">No subscribers found</p>
                @endif
                {{$subscribers->links()}}
            </div>
        </div>
    </div>
</div>
@endsection