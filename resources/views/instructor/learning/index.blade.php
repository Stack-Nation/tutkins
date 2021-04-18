@extends('layouts.authApp')
@section("title","Your Learning Paths")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Learning Path</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Learning Paths</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.learnings.create")}}" class="btn btn-primary">Create new learning path</a>
            </div>
            <div class="table-responsive">
                @if($learnings->count()===0)
                <p>No learning path found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($learnings as $learning)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$learning->title}}</td>
                        <td>{{$learning->price}}</td>
                        @if($learning->certificate===NULL)<td> <a href="{{route("instructor.learnings.certificate.create",$learning->id)}}" class="btn btn-info">Create Certificate</a></td> @endif
                        <td>
                            <form action="{{route("instructor.learnings.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$learning->id}}">
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

                {{$learnings->links()}}

            </div>

        </div>

    </div>
</div>
@endsection