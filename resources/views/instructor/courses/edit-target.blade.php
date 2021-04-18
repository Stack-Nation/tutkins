@extends('layouts.authApp')
@section("title","Edit Target")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Course</h1>
    
    <div class="container page__container page-section">
        @include("includes.instructor-course-menu")
        <div class="page-separator">
            <div class="page-separator__text">Edit Course Target</div>
        </div>
        <form action="{{route("instructor.courses.edit-target",$course->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group" id="learnings">
                <label class="form-label" for="learnings">Learnings in your course</label>
                @if($course->learnings===NULL)
                <input type="text" name="learnings[]" required class="form-control">
                @else
                    <input type="text" name="learnings[]" value="{{$course->learnings[0]}}" required class="form-control">
                    @for ($i = 1; $i < count($course->learnings); $i++)
                        <div class="input-group">
                            <input type="text" required name="learnings[]" value="{{$course->learnings[$i]}}" class="form-control mt-2"/><button style="height:35px" class="btn btn-danger btn-sm input-group-postpend mt-2" type="button" onclick="deleteInput(this)"><i class="fa fa-trash"></i></button>
                        </div>
                    @endfor
                @endif
            </div>
            <button class="btn btn-light" type="button" onclick="addInput('learnings');">+ Add more</button>

            <div class="form-group mt-2" id="requirements">
                <label class="form-label" for="requirements">Requirements for your course</label>
                @if($course->requirements===NULL)
                <input type="text" name="requirements[]" required class="form-control">
                @else
                    <input type="text" name="requirements[]" value="{{$course->requirements[0]}}" required class="form-control">
                    @for ($i = 1; $i < count($course->requirements); $i++)
                        <div class="input-group">
                            <input type="text" required name="requirements[]" value="{{$course->requirements[$i]}}" class="form-control mt-2"/><button style="height:35px" class="btn btn-danger btn-sm input-group-postpend mt-2" type="button" onclick="deleteInput(this)"><i class="fa fa-trash"></i></button>
                        </div>
                    @endfor
                @endif
            </div>
            <button class="btn btn-light" type="button" onclick="addInput('requirements');">+ Add more</button>

            <div class="form-group mt-2" id="targets">
                <label class="form-label" for="targets">Target students for your course</label>
                @if($course->target===NULL)
                <input type="text" name="targets[]" required class="form-control">
                @else
                    <input type="text" name="targets[]" value="{{$course->target[0]}}" required class="form-control">
                    @for ($i = 1; $i < count($course->target); $i++)
                        <div class="input-group">
                            <input type="text" required name="targets[]" value="{{$course->target[$i]}}" class="form-control mt-2"/><button style="height:35px" class="btn btn-danger btn-sm input-group-postpend mt-2" type="button" onclick="deleteInput(this)"><i class="fa fa-trash"></i></button>
                        </div>
                    @endfor
                @endif
            </div>
            <button class="btn btn-light" type="button" onclick="addInput('targets');">+ Add more</button>
            <div class="form-group mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function addInput(obj){
        const input = `
            <div class="input-group">
                <input type="text" required name="${obj}[]" class="form-control mt-2"/><button style="height:35px" class="btn btn-danger btn-sm input-group-postpend mt-2" type="button" onclick="deleteInput(this)"><i class="fa fa-trash"></i></button>
            </div>
        `;
        $(`#${obj}`).append(input);
    }
    function deleteInput(obj){
        $($(obj).parent()).remove()
    }
</script>
@endsection