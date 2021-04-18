@extends('layouts.authApp')
@section("title","Your Mentoring Programs")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentoring Program</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Mentoring Programs</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($mentorings->count()===0)
                <p>No mentoring program found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($mentorings as $mentoring)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td><a href="{{route("mentorings.view",[$mentoring->mentoring->id,md5($mentoring->mentoring->title)])}}" class="btn btn-link">{{$mentoring->mentoring->title}}</a></td>
                        <td>{{$mentoring->mentoring->category->name}}</td>
                        <td>{{$mentoring->mentoring->price}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$mentorings->links()}}

            </div>

        </div>

    </div>
</div>
@endsection