@extends('layouts.authApp')
@section("title","Create an event")
@section('head')
<link rel="stylesheet" href="{{asset("assets/main/assets/plugins/select2/css/select2.min.css")}}">
<style>
    #map{
        height: 300px;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Create an event</h2>
            </div>
            <div class="card-body">
                <form action="{{route("organiser.events.create")}}" onsubmit="checkImages(event)" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 form-group mb-2">
                            <label for="title">Event title</label>
                            <input type="text" name="title" id="title" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="description">Event description</label>
                            <textarea name="description" id="description"></textarea>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="instructions">Event instructions</label>
                            <textarea name="instructions" id="instructions"></textarea>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="category">Event category</label>
                            <select name="category" id="category" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="mode">Event mode</label>
                            <select name="mode" id="mode" onchange="getMode(this);" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a mode</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                        </div>
                        <div class="col-12 form-group mb-2" id="linkD" style="display: none">
                            <label for="link">Event link</label>
                            <input type="text" name="link" id="link" class="form-control form-control-sm">
                        </div>
                        <div id="addD" class="row" style="display:none">
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="country">Country:</label>
                                <input id="country" type="text" class="form-control form-control-sm" name="country">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="state">State:</label>
                                <input id="state" type="text" class="form-control form-control-sm" name="state">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="city">City:</label>
                                <input id="city" type="text" class="form-control form-control-sm" name="city">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="address">Address:</label>
                                <input value="{{$user->address}}" onkeyup="findAdd(this.value);" type="text" class="form-control">
                                <input id="address" hidden type="text" name="address">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="pin_code">Pin Code:</label>
                                <input id="pin_code" type="text" class="form-control form-control-sm" name="pin_code" >
                            </div>
                        </div>
                        <div class="col-12 input-group mb-2">
                            <input type="text" name="duration" id="duration" onkeyup="checkD();" placeholder="Event Duration" class="form-control form-control-sm">
                            <div class="input-group-append">
                                <select name="durationt" id="durationt" onchange="checkD();" class="form-control form-control-sm">
                                    <option value="day">day</option>
                                    <option value="hour">hour</option>
                                    <option value="week">week</option>
                                    <option value="month">month</option>
                                    <option value="year">year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="days">Number of days</label>
                            <input type="number" name="days" id="days" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="batch_size">Batch Size</label>
                            <input type="number" name="batch_size" id="batch_size" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="age_group">Age Group</label>
                            <input type="text" name="age_group" id="age_group" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="days">Number of days</label>
                            <input type="number" name="days" id="days" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="price">Event price</label>
                            <input type="number" name="price" id="price" class="form-control form-control-sm">
                        </div>
                        <div class="col-6 form-group mb-2">
                            <label for="dates">Event Dates</label>
                            <div id="dates">
                                <input type="date" class="form-control form-control-sm mb-2" name="dates[]" min="{{(new DateTime("NOW"))->format("Y-m-d")}}">
                            </div>
                            <button class="btn btn-light btn-sm" id="datebtn" type="button" onclick="addDate()">Add more dates</button>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="times">Event Times</label>
                            <div id="times">
                                <input type="time" class="form-control form-control-sm mb-2" name="times[]">
                            </div>
                            <button class="btn btn-light btn-sm" id="timebtn" type="button" onclick="addTime()">Add more times</button>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label class="form-label" for="images[]">Images:</label>
                            <input id="images" type="file" accept=".png,.jpeg,.jpg" multiple class="form-control" name="images[]">
                        </div>
                        <div class="col-6 form-group mb-2">
                            <label class="form-label" for="thumbnail">Thumbnail:</label>
                            <input id="thumbnail" type="file" accept=".png,.jpeg,.jpg" class="form-control" name="thumbnail">
                        </div>
                        <div class="col-6 form-group mb-2">
                            <label class="form-label" for="video">Explainer video:</label>
                            <input id="video" type="file" accept=".mp4,.webp,.3gp,.mvi" class="form-control" name="video">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label class="form-label" for="links">Reference Links:</label>
                            <div id="linksD">
                                <input type="text" class="form-control mb-3" id="links" name="links[]">
                            </div>
                            <button class="btn btn-info" type="button" onclick="addLinks()">Add more links</button>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
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
ClassicEditor
    .create( document.querySelector( '#instructions' ) )
    .catch( error => {
        console.error( error );
    });

    function getMode(obj){
        if($(obj).val()=="Online"){
            $("#linkD").css("display","block");
        }
        else{
            $("#linkD").css("display","none");
        }
        if($(obj).val()=="Offline"){
            $("#addD").css("display","flex");
        }
        else{
            $("#addD").css("display","none");
        }
    }
    function addDate(){
        const time = `<input type="date" class="form-control mb-2" name="dates[]" min="{{(new DateTime("NOW"))->format("Y-m-d")}}">`;
        $("#dates").append(time);
    }
    function addTime(){
        const time = `<input type="time" class="form-control mb-2" name="times[]">`;
        $("#times").append(time);
    }
    function checkD(){
        if($("#duration").val()>=1){
            if($("#durationt").val()=="hour" && $("#duration").val()>=25){
                $("#datebtn").css("display","inline");
                $("#timebtn").css("display","inline");
            }
            else if($("#durationt").val()=="day" && $("#duration").val()>1){
                $("#datebtn").css("display","inline");
                $("#timebtn").css("display","inline");
            }
            else if(($("#durationt").val()!=="day" && $("#durationt").val()!=="hour") && $("#duration").val()>=1){
                $("#datebtn").css("display","inline");
                $("#timebtn").css("display","inline");

            }
            else{
                $("#datebtn").css("display","none");
                $("#timebtn").css("display","none");
            }
        }
    }

    function checkImages(e){
        var $fileUpload = $("#images");
        if (parseInt($fileUpload.get(0).files.length)>4){
            e.preventDefault()
            alert("You can only upload a maximum of 4 files");
            return false;
        }
        else{
            return true;
        }
    }
    function addLinks(){
        $("#linksD").append(`
            <input type="text" class="form-control mb-3" id="links" name="links[]">
        `);
    }
</script>
<script src="{{asset("assets/main/assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/main/js/plugins-init/select2-init.js")}}"></script>
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