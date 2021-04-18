@extends('layouts.authApp')
@section("title","Create Question")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new question</div>
        </div>
        <form action="{{route("instructor.exams.questions.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Question title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="marks">Marks:</label>
                <input id="marks" type="number" class="form-control" name="marks" placeholder="Question marks ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="isnegmark">Negative Marking?:</label>
                <select name="isnegmark" class="custom-select" id="isnegmark" onclick="getnegMark(this)">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
            <div class="form-group" id="negmarks" style="display:none">
                <label class="form-label" for="nmarks">Negative Marks:</label>
                <input id="nmarks" type="number" class="form-control" name="nmarks" placeholder="Question negative mark ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="type">Type:</label>
                <select name="type" onchange="getAnswers(this)" class="custom-select" id="type">
                    <option value="">Select a type</option>
                    <option value="Paragraph">Paragraph</option>
                    <option value="Single Choice">Single Choice</option>
                    <option value="Multiple Choice">Multiple Choice</option>
                </select>
            </div>
            <div id="answers"></div>
            <div id="explainations" style="display:none">
                <div class="page-separator">
                    <div class="page-separator__text">Explaination</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="explaination1">Explain why answer 1 is correct/incorrect:</label>
                    <textarea name="explaination1" class="explainations"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="explaination2">Explain why answer 2 is correct/incorrect:</label>
                    <textarea name="explaination2" class="explainations"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="explaination3">Explain why answer 3 is correct/incorrect:</label>
                    <textarea name="explaination3" class="explainations"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="explaination4">Explain why answer 4 is correct/incorrect:</label>
                    <textarea name="explaination4" class="explainations"></textarea>
                </div>
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
    const explainations = $(".explainations");
    explainations.map((key,exp)=>{
        ClassicEditor
            .create( exp )
            .catch( error => {
                console.error( error );
            });
    })
    localStorage.setItem("option","false");
</script>
<script>
    function getAnswers(obj){
        const val = $(obj).val();
        if(val===""){
            $("#explainations").css("display","none")
        }
        else{
            localStorage.setItem("option","false");
            let content = "";
            if(val==="Paragraph"){
                content = `
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option1">Option 1:</label>
                        <input type="hidden" value=0 name="iscorrect1">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <textarea name="option1" class="options"></textarea>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option2">Option 2:</label>
                        <input type="hidden" value=0 name="iscorrect2">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <textarea name="option2" class="options"></textarea>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option3">Option 3:</label>
                        <input type="hidden" value=0 name="iscorrect3">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <textarea name="option3" class="options"></textarea>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option4">Option 4:</label>
                        <input type="hidden" value=0 name="iscorrect4">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <textarea name="option4" class="options"></textarea>
                    </div>
                `;
            }
            else if(val==="Single Choice"){
                content = `
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option1">Option 1:</label>
                        <input type="hidden" value=0 name="iscorrect1">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option1" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option2">Option 2:</label>
                        <input type="hidden" value=0 name="iscorrect2">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option2" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option3">Option 3:</label>
                        <input type="hidden" value=0 name="iscorrect3">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option3" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="single">
                        <label class="form-label" for="option4">Option 4:</label>
                        <input type="hidden" value=0 name="iscorrect4">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option4" type="text" class="form-control options"/>
                    </div>
                `;
            }
            else if(val==="Multiple Choice"){
                content = `
                    <div class="form-group" data-type="multi">
                        <label class="form-label" for="option1">Option 1:</label>
                        <input type="hidden" value=0 name="iscorrect1">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option1" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="multi">
                        <label class="form-label" for="option2">Option 2:</label>
                        <input type="hidden" value=0 name="iscorrect2">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option2" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="multi">
                        <label class="form-label" for="option3">Option 3:</label>
                        <input type="hidden" value=0 name="iscorrect3">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option3" type="text" class="form-control options"/>
                    </div>
                    <div class="form-group" data-type="multi">
                        <label class="form-label" for="option4">Option 4:</label>
                        <input type="hidden" value=0 name="iscorrect4">
                        <button type="button" class="btn btn-success" onclick="makeCorrect(this)">Mark this option as correct</button>
                        <input name="option4" type="text" class="form-control options"/>
                    </div>
                `;
            }
            $("#answers").html(content);
            if(val==="Paragraph"){
                checkPara();
            }
            $("#explainations").css("display","block")
        }
    }
    function makeCorrect(obj){
        if($($($(obj).parent()).children()[1]).val()=="0" || $($($(obj).parent()).children()[1]).val()==0){
            if($($(obj).parent()).data("type")=="single" && localStorage.getItem("option")=="true"){
                alert("You have already selected an answer. Please uncheck the current one to make this option as your answer, or select multiple choice type");
            }
            else{
                localStorage.setItem("option","true");
                $($($(obj).parent()).children()[1]).val(1)
            }
        }
        else{
            localStorage.setItem("option","false");
            $($($(obj).parent()).children()[1]).val(0)
        }
        checkCorrect();
    }
    function checkCorrect(){
        const cas = $("input[name^=iscorrect]");
        cas.map((key,ca) => {
            if($(ca).val()==1 || $(ca).val()=="1"){
                $($($(ca).parent()).children()[3]).css("background-color","#7DF700");
                $($($(ca).parent()).children()[3]).css("color","white");
                $($($(ca).parent()).children()[2]).removeClass("btn-success");
                $($($(ca).parent()).children()[2]).addClass("btn-danger");
                $($($(ca).parent()).children()[2]).html("Mark this option as incorrect");
            }
            else{
                $($($(ca).parent()).children()[3]).css("background-color","white");
                $($($(ca).parent()).children()[3]).css("color","black");
                $($($(ca).parent()).children()[2]).removeClass("btn-danger");
                $($($(ca).parent()).children()[2]).addClass("btn-success");
                $($($(ca).parent()).children()[2]).html("Mark this option as correct");
            }
        });
    }
    function checkPara(){
        const explainations = $(".options");
        explainations.map((key,exp)=>{
            ClassicEditor
                .create( exp )
                .catch( error => {
                    console.error( error );
                });
        })
    }
    function getnegMark(obj){
        const val = $(obj).val();
        if(val==="yes"){
            $("#negmarks").css("display","block");
        }
        else{
            $("#negmarks").css("display","none");
        }
    }
</script>
@endsection