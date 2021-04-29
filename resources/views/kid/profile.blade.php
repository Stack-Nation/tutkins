@extends('layouts.authApp')
@section("title","Kid Profile")
@section("head")
<style>
    #map{
        height: 300px;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <h2>Kid Profile</h2>
        <form method="POST" action="{{ route('kid.profile') }}" class="col-md-10 p-0 mx-auto" enctype="multipart/form-data">
            <img src="{{asset("assets/users/photo/".($user->photo??"default.png"))}}" height="100px" width="100px" alt="photo" class="mb-3 rounded">
            @csrf
            <div class="form-group">
                <label class="form-label" for="photo">Photo:</label>
                <input id="photo" value="{{$user->photo}}" type="file" class="form-control" name="photo">
            </div>
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
                <textarea name="description" id="description">{{$user->description}}</textarea>
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
                <input value="{{$user->address}}" onkeyup="findAdd(this.value);" type="text" class="form-control">
                <input id="address" value="{{$user->address}}" hidden type="text" name="address">
            </div>
            <div class="form-group">
                <div id="map"></div>
            </div>
            <div class="form-group">
                <label class="form-label" for="pin_code">Pin Code:</label>
                <input id="pin_code" value="{{$user->pin_code}}" type="text" class="form-control" name="pin_code" >
            </div>
            <div class="form-group">
                <label class="form-label" for="aadhar">Aadhar number:</label>
                <input id="aadhar" value="{{$user->aadhar}}" type="text" class="form-control" name="aadhar" >
            </div>
            <div>
                <button class="btn btn-primary">Update</button>
            </div>
        </form>

        <hr>
        <h3 class="float-left">Parent Information</h3>@if($user->parent_info==NULL or count(json_decode($user->parent_info))<2)<button data-toggle="modal" data-target="#parentModal" class="btn btn-primary btn-sm ml-4">Add Information</button>@endif
        @if($user->parent_info===NULL)
            <p>No data added.</p>
        @else
            <div class="row mt-3">
            @foreach (json_decode($user->parent_info) as $parent)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{$parent->name}}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{$parent->description}}</p>
                        <hr>
                        <p>Date Of Birth: {{\Carbon\Carbon::parse($parent->dob)->format("d M Y")}}</p>
                        <hr>
                        <p>Occupation: {{$parent->occupation}}</p>
                        <hr>
                        <p>Company: {{$parent->company}}</p>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
@section('modals')
<div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h3>Add Parent Information</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{route("user.parent")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-2">
                <input type="text" name="name" placeholder="Parent Name" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="description" placeholder="Description" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="date" name="dob" placeholder="Date Of Birth" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="occupation" placeholder="Occupation" class="form-control">
            </div>
            <div class="form-group mb-2">
                <input type="text" name="company" placeholder="Company Name" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Add</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
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
<script async src="https://maps.googleapis.com/maps/api/js?key={{env("GOOGLE_MAPS_API")}}&callback=initMap&libraries=places"></script>
<script>
    let map;
    let service;
    let infowindow;
    
    function initMap() {
      const sydney = new google.maps.LatLng(-33.867, 151.195);
      infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById("map"), {
            center: sydney,
            zoom: 15,
        });
    }
    
    async function findAdd (query){
      const request = {
        query: query,
        fields: ["name", "geometry"],
      };
      service = new google.maps.places.PlacesService(map);
      service.findPlaceFromQuery(request, (results, status) => {
        if (status === google.maps.places.PlacesServiceStatus.OK && results) {
          for (let i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
          map.setCenter(results[0].geometry.location);
          const pos = {
              "lat":results[0].geometry.location.lat(),
              "lng":results[0].geometry.location.lng(),
          }
            const geocoder = new google.maps.Geocoder();
            geocodeLatLng(geocoder, map, infowindow,pos);
        }
      });
    }

    function geocodeLatLng(geocoder, map, infowindow,pos) {
        const latlng = {
            lat: parseFloat(pos.lat),
            lng: parseFloat(pos.lng),
        };
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {
            if (results[0]) {
                map.setZoom(11);
                const marker = new google.maps.Marker({
                position: latlng,
                map: map,
                });
                infowindow.setContent(results[0].formatted_address);
                infowindow.open(map, marker);
                $("#address").val(results[0].formatted_address)
            } else {
                window.alert("No results found");
            }
            } else {
            window.alert("Geocoder failed due to: " + status);
            }
        });
    }
    
    function createMarker(place) {
      if (!place.geometry || !place.geometry.location) return;
      const marker = new google.maps.Marker({
        map,
        position: place.geometry.location,
      });
      google.maps.event.addListener(marker, "click", () => {
        infowindow.setContent(place.name || "");
        infowindow.open(map);
      });
    }
    </script>
@endsection