@extends('layouts.authApp')
@section("title","Your Webinars")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Webinar</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Webinars</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.webinars.create")}}" class="btn btn-primary">Create new webinar</a>
            </div>
            <div class="table-responsive">
                @if($webinars->count()===0)
                <p>No webinar found.</p>
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
                    @foreach ($webinars as $webinar)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$webinar->title}}</td>
                        <td>{{$webinar->category->name}}</td>
                        <td>{{$webinar->price}}</td>
                        @if($webinar->form===NULL)<td> <a href="{{route("instructor.webinars.form.create",$webinar->id)}}" class="btn btn-info">Create questionair form</a></td> @endif
                        <td>
                            <form action="{{route("instructor.webinars.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$webinar->id}}">
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

                {{$webinars->links()}}

            </div>

        </div>

    </div>
</div>
@endsection