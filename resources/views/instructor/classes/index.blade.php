@extends('layouts.authApp')
@section("title","Live classes")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Classes</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Live Classes</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.classes.create")}}" class="btn btn-primary">Create new live class</a>
            </div>

            <div class="table-responsive">
                @if($classes->count()===0)
                <p>No class found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Date and Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($classes as $class)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$class->title}}</td>
                                <td>{{$class->course->title}}</td>
                                <td>{{$class->price}}</td>
                                <td>{{$class->discount}}%</td>
                                <td>{{$class->date}} | {{$class->time}}</td>
                                <td>
                                    @if($class->meeting_site==="meet")
                                    <a href="https://meet.google.com/{{$class->meeting_id}}" target="_blank" class="btn btn-success">Go to meeting</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$classes->links()}}

            </div>

        </div>

    </div>
</div>
@endsection