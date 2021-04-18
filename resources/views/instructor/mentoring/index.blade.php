@extends('layouts.authApp')
@section("title","Your Mentoring Programs")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentoring</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Mentoring Programs</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.mentorings.create")}}" class="btn btn-primary">Create new mentoring program</a>
            </div>
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
                        <td>{{$mentoring->title}}</td>
                        <td>{{$mentoring->category->name}}</td>
                        <td>{{$mentoring->price}}</td>
                        @if($mentoring->form===NULL)<td> <a href="{{route("instructor.mentorings.form.create",$mentoring->id)}}" class="btn btn-info">Create questionair form</a></td> @endif
                        <td>
                            <form action="{{route("instructor.mentorings.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$mentoring->id}}">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
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