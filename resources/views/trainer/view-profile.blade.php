@extends('layouts.authApp')
@section("title",$user->name." Profile")
@section('content')
<div class="row">
    <div class="col-12">
        <h2>{{$user->name}} Profile</h2>
            <img src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" height="100px" width="100px" alt="photo" class="mb-3 rounded">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Name:</label>
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
                <div>{!!$user->description??"Not set"!!}</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="dob">Date of birth:</label>
                <input id="dob" @if($user->dob)value="{{\Carbon\Carbon::parse($user->dob)->format("Y-m-d")}}" @endif type="date" class="form-control" name="dob">
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
                <label class="form-label" for="occupation">Occupation:</label>
                <input id="occupation" value="{{$user->occupation}}" type="text" class="form-control" name="occupation" >
            </div>
            <div class="form-group">
                <label class="form-label" for="proficiency">Proficiency:</label>
                <input id="proficiency" value="{{$user->proficiency}}" type="text" class="form-control" name="proficiency" >
            </div>

        <hr>
        <h3>Training Information</h3>
        @if($user->training===NULL)
            <p>No data added.</p>
        @else
            <div class="row mt-3">
            @foreach (json_decode($user->training) as $training)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$training->title}}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{$training->description}}</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-5">
                                <a href="{{asset("assets/users/training/document/".$training->document)}}" class="btn btn-success ">View Document</a>
                            </div>
                            <div class="col-lg-5 ml-2">
                                <a href="{{asset("assets/users/training/video/".$training->video)}}" class="btn btn-info ">View Self Video</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<script>
    window.onload = () => {
        $("input").map((key,input) => {
            $(input).prop("readonly",true);
        })
    }
</script>
@endsection