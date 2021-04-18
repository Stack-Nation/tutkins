@extends('layouts.authApp')
@section("title","Edit Curriculum")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Course</h1>
    
    <div class="container page__container page-section">
        @include("includes.instructor-course-menu")
        <div class="page-separator">
            <div class="page-separator__text">Edit Course Curriculum</div>
        </div>
        <form action="{{route("instructor.courses.edit-cir",$course->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="sections" style="background:white">
                @if($course->content===NULL)
                @else
                <?php $i=0; ?>
                    @foreach ($course->content as $key => $content)
                    <div class="form-group p-3" id="{{$i}}">
                        <input type="text" class="form-control" value="{{$key}}" placeholder="Section Title" name="section_title[]" required/>
                        <input type="hidden" value="{{$i}}" name="section_key[]"/>
                        <input type="text" value="{{$content->objective}}" class="form-control mt-2" placeholder="Section Objective" name="section_objective[]"/>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button class="btn btn-info" type="button" onclick="addContent(this);">Add Content</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger" type="button" onclick="deleteSection(this);">Delete section</button>
                            </div>
                        </div>
                        @foreach ($content->content as $k=>$v)
                        <div class="form-group p-3">
                            <input type="text" value="{{$v->lecture_title}}" class="form-control" placeholder="Lecture Title" name="lecture_title[]"/>
                            <input type="hidden" value="{{$v->type}}" name="type[]">
                            <input type="hidden" value="{{$i}}" name="section_id[]" value="${section_id}">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button class="btn btn-info" type="button" onclick="modData(this)">Add Data</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-danger" type="button" onclick="deleteItem(this);">Delete {{$v->type}}</button>
                                </div>
                            </div>
                            <div class="collapse pt-2 pb-2">
                                @if($v->type==="lecture")
                                <div>
                                    <input type="hidden" value="{{$v->data[0]->type}}" name="lecture_type[]" />
                                    <input type="hidden" value="{{$v->data[0]->data}}" name="lecture_data[]" />
                                    <input type="file" hidden class="form-control" name="lecture_data[]" />
                                    <iframe src="{{$v->data[0]->data}}" width="500px" height="500px" frameborder="0"></iframe>
                                </div>
                                @else
                                <input name="quiz_data[]" value="{{count($v->data)}}" type="hidden">
                                <button class="btn btn-light" type="button" onclick="addQuestion(this)">+ Add Question</button>
                                @foreach ($v->data as $ques)
                                <div class="form-group p-3">
                                    <input type="text" class="form-control" value="{{$ques->question_title}}" placeholder="Question" name="question_title[]"/>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" value="{{$ques->answers[0]->answer}}" class="form-control" placeholder="Option" name="answer1[]"/>
                                                <input type="hidden" value="{{$ques->answers[0]->iscorrect}}" name="correct_answer1[]"/>
                                                <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" value="{{$ques->answers[1]->answer}}" class="form-control" placeholder="Option" name="answer2[]"/>
                                                <input type="hidden" value="{{$ques->answers[1]->iscorrect}}" name="correct_answer2[]"/>
                                                <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" value="{{$ques->answers[2]->answer}}" class="form-control" placeholder="Option" name="answer3[]"/>
                                                <input type="hidden" value="{{$ques->answers[2]->iscorrect}}" name="correct_answer3[]"/>
                                                <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" value="{{$ques->answers[3]->answer}}" class="form-control" placeholder="Option" name="answer4[]"/>
                                                <input type="hidden" value="{{$ques->answers[3]->iscorrect}}" name="correct_answer4[]"/>
                                                <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <?php $i++; ?>
                    @endforeach
                @endif
            </div>
            <button class="btn btn-light" type="button" onclick="addSection();">+ Add Section</button>
            <div class="form-group mt-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    window.onload = checkCorrect();
    localStorage.setItem("section_id",{{count((array)$course->content)}});
    function addSection(){
        const id = localStorage.getItem("section_id");
        const section = `
            <div class="form-group p-3" id="${id}">
                <input type="text" class="form-control" placeholder="Section Title" name="section_title[]" required/>
                <input type="hidden" value="${id}" name="section_key[]"/>
                <input type="text" class="form-control mt-2" placeholder="Section Objective" name="section_objective[]"/>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <button class="btn btn-info" type="button" onclick="addContent(this);">Add Content</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="deleteSection(this);">Delete section</button>
                    </div>
                </div>
            </div>
        `;
        localStorage.setItem("section_id",parseInt(localStorage.getItem("section_id"))+1)
        $("#sections").append(section)
    }
    function deleteSection(obj){
        $($($($(obj).parent()).parent()).parent()).remove();
        localStorage.setItem("section_id",parseInt(localStorage.getItem("section_id"))-1)
    }
    function addContent(obj){
        const id = $($($($(obj).parent()).parent()).parent()).attr("id");
        const content = `
            <div class="form-group" id="${id}">
                <select id="content" class="mt-2 custom-select" onchange="addData(this)">
                    <option value="">Select a type of content</option>
                    <option value="lecture">Lecture</option>
                    <option value="quiz">Quiz</option>
                </select>
            </div>
        `;
        $($($($(obj).parent()).parent()).parent()).append(content);
    }
    function addData(obj){
        let content = "";
        const section_id = $($(obj).parent()).attr("id");
        if($(obj).val()===""){
            alert("Please choose a valid type")
        }
        else if ($(obj).val()==="lecture"){
            content = `
            <div class="form-group p-3">
                <input type="text" class="form-control" placeholder="Lecture Title" name="lecture_title[]"/>
                <input type="hidden" name="type[]" value="lecture">
                <input type="hidden" name="section_id[]" value="${section_id}">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <button class="btn btn-info" type="button" onclick="modData(this)">Add Data</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="deleteItem(this);">Delete lecture</button>
                    </div>
                </div>
                <div class="collapse pt-2 pb-2">
                    <select class="custom-select" onchange="changeType(this)">
                        <option value="">Choose a type</option>
                        <option value="video">Video</option>
                        <option value="document">Document</option>
                    </select>
                </div>
            </div>
            `;
        }
        else if ($(obj).val()==="quiz"){
            content = `
            <div class="form-group p-3">
                <input type="text" class="form-control" placeholder="Quiz Title" name="lecture_title[]"/>
                <input type="hidden" name="type[]" value="quiz">
                <input type="hidden" name="section_id[]" value="${section_id}">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <button class="btn btn-info" type="button" onclick="modData(this)">Add Data</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="deleteItem(this);">Delete quiz</button>
                    </div>
                </div>
                <div class="collapse pt-2 pb-2">
                    <input name="quiz_data[]" value="0" type="hidden">
                    <button class="btn btn-light" type="button" onclick="addQuestion(this)">+ Add Question</button>
                </div>
            </div>
            `;
        }
        else{
            alert("Please choose a valid type")
        }
        const section = $($(obj).parent()).parent();
        $($(obj).parent()).remove()
        $(section).append(content);
    }
    function modData(obj){
        $($($($($(obj).parent()).parent()).parent()).children()[4]).collapse("toggle")
    }
    function changeType(obj){
        const val = $(obj).val();
        let content = "";
        if(val===""){
            alert("Choose a valid type")
        }
        else{
            content = `
                <div>
                    <input type="file" class="form-control" name="lecture_data[]" />
                    <input type="hidden" value="empty" name="lecture_data[]" />
                    <input type="hidden" value="${val}" name="lecture_type[]" />
                </div>
            `
        }
        const col = $(obj).parent();
        $(obj).remove();
        $(col).html(content);
    }
    function addQuestion(obj){
        $($($(obj).parent()).children()[0]).val(parseInt($($($(obj).parent()).children()[0]).val())+1)
        const question = `
            <div class="form-group p-3"">
                <input type="text" class="form-control" placeholder="Question" name="question_title[]"/>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Option" name="answer1[]"/>
                            <input type="hidden" value="0" name="correct_answer1[]"/>
                            <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Option" name="answer2[]"/>
                            <input type="hidden" value="0" name="correct_answer2[]"/>
                            <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Option" name="answer3[]"/>
                            <input type="hidden" value="0" name="correct_answer3[]"/>
                            <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Option" name="answer4[]"/>
                            <input type="hidden" value="0" name="correct_answer4[]"/>
                            <button class="btn btn-success" type="button" onclick="makeCorrect(this)">Make this a correct answer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $($(obj).parent()).append(question)
    }
    function deleteItem(obj){
        $($($($(obj).parent()).parent()).parent()).remove();
    }
    function makeCorrect(obj){
        if($($($(obj).parent()).children()[1]).val()===0 || $($($(obj).parent()).children()[1]).val()==="0" || $($($(obj).parent()).children()[1]).val()=="0" || $($($(obj).parent()).children()[1]).val()==0){
            $($($(obj).parent()).children()[1]).val(1)
        }
        else{
            $($($(obj).parent()).children()[1]).val(0)
        }
        checkCorrect();
    }

    function checkCorrect(){
        const cas = $("input[name^=correct_answer]");
        cas.map((key,ca) => {
            if($(ca).val()==1 || $(ca).val()=="1"){
                $($($(ca).parent()).children()[0]).css("background-color","#7DF700");
                $($($(ca).parent()).children()[0]).css("color","white");
            }
            else{
                $($($(ca).parent()).children()[0]).css("background-color","white");
                $($($(ca).parent()).children()[0]).css("color","black");
            }
        });
    }
</script>
@endsection