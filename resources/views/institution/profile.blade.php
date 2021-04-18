@extends('layouts.authApp')
@section("title","Profile")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <form method="POST" action="{{ route('institution.profile') }}" class="col-md-10 p-0 mx-auto" enctype="multipart/form-data">
            <img src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" height="100px" width="100px" alt="photo" class="mb-3 rounded">
            @csrf
            <div class="form-group">
                <label class="form-label" for="photo">Logo:</label>
                <input id="photo" value="{{$user->photo}}" type="file" class="form-control" name="photo">
            </div>
            <div class="form-group">
                <label class="form-label" for="name">Registered Name:</label>
                <input id="name" value="{{$user->name}}" type="text" class="form-control" name="name" required placeholder="Your name ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email:</label>
                <input id="email" value="{{$user->email}}" type="email" class="form-control" name="email" required placeholder="Your email address ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="mobile">Mobile Number:</label>
                <input id="mobile" value="{{$user->mobile}}" type="tel" class="form-control" name="mobile" required placeholder="Your mobile number ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description">{{$user->description}}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="category">Category:</label>
                <select name="category" id="category" class="custom-select">
                    <option value="">Select a category</option>
                    <option value="Startup" {{$user->category==="Startup"?"selected":""}}>Startup</option>
                    <option value="Sole/OPC" {{$user->category==="Sole/OPC"?"selected":""}}>Sole/OPC</option>
                    <option value="PvtLtd/LLP" {{$user->category==="PvtLtd/LLP"?"selected":""}}>PvtLtd/LLP</option>
                    <option value="LLC/Inc" {{$user->category==="LLC/Inc"?"selected":""}}>LLC/Inc</option>
                    <option value="NGO/Trust" {{$user->category==="NGO/Trust"?"selected":""}}>NGO/Trust</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="brand_name">Brand Name:</label>
                <input id="brand_name" value="{{$user->brand_name}}" type="text" class="form-control" name="brand_name">
            </div>
            <div class="form-group">
                <label class="form-label" for="founded_by">Founder Name:</label>
                <input id="founded_by" value="{{$user->founded_by}}" type="text" class="form-control" name="founded_by">
            </div>
            <div class="form-group">
                <label class="form-label" for="founded">Founded Date:</label>
                <input id="founded" value="{{\Carbon\Carbon::parse($user->founded)->format("Y-m-d")}}" type="date" class="form-control" name="founded">
            </div>
            <div class="form-group">
                <label class="form-label" for="country">Country:</label>
                <input id="country" value="{{$user->country}}" type="text" class="form-control" name="country">
            </div>
            <div class="form-group">
                <label class="form-label" for="state">State:</label>
                <input id="state" value="{{$user->state}}" type="text" class="form-control" name="state">
            </div>
            <div class="form-group">
                <label class="form-label" for="city">City:</label>
                <input id="city" value="{{$user->city}}" type="text" class="form-control" name="city">
            </div>
            <div class="form-group">
                <label class="form-label" for="address">Address:</label>
                <input id="address" value="{{$user->address}}" type="text" class="form-control" name="address">
            </div>
            <div class="form-group">
                <label class="form-label" for="pin_code">Pin Code:</label>
                <input id="pin_code" value="{{$user->pin_code}}" type="text" class="form-control" name="pin_code" >
            </div>
            <div class="form-group">
                <label class="form-label" for="poc_name">PoC Name:</label>
                <input id="poc_name" value="{{$user->poc_name}}" type="text" class="form-control" name="poc_name" >
            </div>
            <div class="form-group">
                <label class="form-label" for="poc_email">PoC Email:</label>
                <input id="poc_email" value="{{$user->poc_email}}" type="text" class="form-control" name="poc_email" >
            </div>
            <div class="form-group">
                <label class="form-label" for="poc_mobile">PoC Mobile:</label>
                <input id="poc_mobile" value="{{$user->poc_mobile}}" type="text" class="form-control" name="poc_mobile" >
            </div>
            <div class="form-group">
                <label class="form-label" for="poc_identity">PoC Identity Proof:</label>
                <input id="poc_identity" value="{{$user->poc_identity}}" type="file" class="form-control" name="poc_identity" >
            </div>
            <div class="form-group">
                <label class="form-label" for="poc_residence">PoC Residence Proof:</label>
                <input id="poc_residence" value="{{$user->poc_residence}}" type="file" class="form-control" name="poc_residence" >
            </div>
            <div class="form-group">
                <label class="form-label" for="reg_doc">Registration Document:</label>
                <input id="reg_doc" value="{{$user->reg_doc}}" type="file" class="form-control" name="reg_doc" >
            </div>
            <div class="form-group">
                <label class="form-label" for="gstin">GSTIN:</label>
                <input id="gstin" value="{{$user->gstin}}" type="text" class="form-control" name="gstin" >
            </div>
            <div class="form-group">
                <label class="form-label" for="gst_doc">GST Document:</label>
                <input id="gst_doc" value="{{$user->gst_doc}}" type="file" class="form-control" name="gst_doc" >
            </div>
            <div class="form-group">
                <label class="form-label" for="cin">CIN:</label>
                <input id="cin" value="{{$user->cin}}" type="text" class="form-control" name="cin" >
            </div>
            <div class="form-group">
                <label class="form-label" for="company_master">Company Master Data:</label>
                <input id="company_master" value="{{$user->company_master}}" type="file" class="form-control" name="company_master" >
            </div>
            <div>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection