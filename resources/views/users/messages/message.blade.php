@extends('layouts.authApp')
@section("title","Message")
@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <h3>Start Conversation with {{\App\Models\User::find($receiver)->name}}</h3>
            <form action="{{route("user.message",$receiver)}}" method="post">
                @csrf
                <textarea name="message" id="message" hidden></textarea>
                <div class="rounded p-2 border border-dark" onkeyup="document.getElementById('message').value = this.innerHTML;" style="height: 150px;overflow:auto" contenteditable="true"></div>
                <button type="submit" class="btn btn-primary">Send Message</button>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection