@extends('layouts.authApp')
@section("title","Admin Courses")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Courses</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">{{$type}} Courses</div>
        </div>
        <select name="role" class="custom-select mb-3" id="role" onchange="getType(this);">
            <option value="Approved" @if($type==="Approved") selected @endif>Approved Courses</option>
            <option value="Pending" @if($type==="Pending") selected @endif>Submitted for review</option>
        </select>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">

            <div class="table-responsive"
                data-toggle="lists"
                data-lists-sort-by="js-lists-values-date"
                data-lists-sort-desc="true"
                data-lists-values='["js-lists-values-lead", "js-lists-values-project", "js-lists-values-status", "js-lists-values-budget", "js-lists-values-date"]'>
                @if($courses->count()===0)
                <p>No course found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Instructor Email</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($courses as $course)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$course->title}}</td>
                                <td>{{$course->instructor->email}}</td>
                                <td>{{$course->category->name}}</td>
                                <td>{{$course->languagee->name}}</td>
                                @if($course->approved===0)
                                <td>
                                    <form action="{{route("admin.course.approve")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$course->id}}">
                                        <button class="btn btn-success"><i class="fa fa-check"></i></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{route("admin.course.reject")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$course->id}}">
                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$courses->links()}}

            </div>

        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
    function getType(obj){
        const val = $(obj).val();
        location.href = `{{route('admin.courses')}}/${val}`
    }
</script>
@endsection