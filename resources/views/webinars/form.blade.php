@extends('layouts.app')
@section("title",$webinar->title." form")
@section('content')
<div class="mdk-box bg-primary js-mdk-box mb-0"
     data-effects="blend-background">
    <div class="mdk-box__content">
        <div class="hero py-64pt text-center text-sm-left">
            <div class="container page__container">
                <h1 class="text-white">{{$webinar->title}}</h1>
            </div>
        </div>
    </div>
</div>

<div class="page-section bg-white border-bottom-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Fill Form</h1>
                <form action="{{route("webinars.subscribe.fill-form",$webinar->id)}}" method="post">
                    @csrf
                    <div id="wrap">
                        
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset("assets/formbuilder/form-render.min.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
    let formData = JSON.stringify(`{{$webinar->form}}`);
    formData = formData.replace(/&quot;/g,'\\"')
    formData = JSON.parse(formData)
    console.log(formData)
    const formRenderOpts = {
      dataType: 'json',
      formData: formData
    };
    var renderedForm = $('<div>');
    renderedForm.formRender(formRenderOpts);
    const wrap = $('#wrap');
    wrap.html(renderedForm.html())
</script>
@endsection