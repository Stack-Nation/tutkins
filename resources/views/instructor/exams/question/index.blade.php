@extends('layouts.authApp')
@section("title","Your Questions")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Questions</div>
        </div>
        <select name="role" class="custom-select mb-3" id="role" onchange="getType(this);">
            <option value="subjects" @if($type==="subjects") selected @endif>Subjects</option>
            <option value="categories" @if($type==="categories") selected @endif>Categories</option>
            <option value="questions" @if($type==="questions") selected @endif>Questions</option>
        </select>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.exams.questions.create")}}" class="btn btn-primary">Create new question</a>
            </div>
            <div class="table-responsive">
                @if($questions->count()===0)
                <p>No question found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($questions as $question)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$question->title}}</td>
                        <td>{{$question->type}}</td>
                        <td>
                            <form action="{{route("instructor.exams.questions.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$question->id}}">
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

                {{$questions->links()}}

            </div>

        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
    function getType(obj){
        const val = $(obj).val();
        if(val==="subjects"){
            location.href = "{{route('instructor.exams')}}"
        }
        else if(val==="categories"){
            location.href = "{{route('instructor.exams.categories')}}"
        }
        else if(val==="questions"){
            location.href = "{{route('instructor.exams.questions')}}"
        }
    }
</script>
@endsection