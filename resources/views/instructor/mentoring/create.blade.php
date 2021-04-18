@extends('layouts.authApp')
@section("title","Create Mentoring Program")
@section('content')

<!-- Main content -->
<section class="content">
    <div class="row">			  
        <div class="col-lg-12 col-12">
              <div class="box">
                <div class="box-header with-border">
                  <h4 class="box-title">Create Mentoring Program</h4>
                </div>
                <!-- /.box-header -->
                <form class="form" action="{{route("instructor.mentorings.create")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <h4 class="box-title text-info"><i class="ti-user mr-15"></i> Program Info</h4>
                        <hr class="my-15">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Program Name</label>
                              <input id="title" type="text" class="form-control" name="title" placeholder="Mentoring program title ...">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Program Description</label>
                                <textarea name="description" id="description"></textarea>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label>Location:</label>
                                <select class="form-control" name="location">
                                    <option>Select </option>
                                  <option>Google Meet</option>
                                  <option>Zoom Call</option>
                                  <option>Jitsi Meet</option>
                                </select>
                              </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label >Program Link</label>
                              <input type="text" class="form-control" placeholder="Program Link" name="link">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="category">Category:</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a category</option>
                                        @foreach ($cats as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Thumbnail</label>
                                    <input id="thumbnail" type="file" accept=".png,.jpeg,.jpg" class="form-control" name="thumbnail">
                                </div>
                            </div>
                        </div>
                        <h4 class="box-title text-info"><i class="ti-save mr-15"></i> Program Schedule</h4>
                        <hr class="my-15">
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label> Select Date range</label>
                              <select class="form-control" name="availability">
                                <option value="">Select a date range..</option>
                                <option value="30">30 Calendar Dates into the future</option>
                                <option value="60">60 Calendar Dates into the future</option>
                                <option value="15">15 Calendar Dates into the future</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Program Duration</label>
                              <select class="form-control" name="duration">
                                <option value="">Select</option>
                                <option value="30 Minutes">30 Minutes</option>
                                <option value="45 Minutes">45 Minutes</option>
                                <option value="60 Minutes">60 Minutes</option>
                                <option value="2 Hours">2 Hours</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Select start times</label>
                              <div id="times">
                              <input type="time" class="form-control mb-2" name="times[]">
                              </div>
                              <button class="btn btn-light btn-sm" type="button" onclick="addTime()">Add more time</button>
                            </div>
                          </div>
                        </div>
                    
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        
                        <button type="submit" class="btn btn-rounded btn-primary btn-outline">
                          <i class="ti-save-alt"></i> Next
                        </button>
                    </div>  
                </form>
              </div>
              <!-- /.box -->			
        </div>  

    </div>


</section>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });

function addTime(){
  const time = `<input type="time" class="form-control mb-2" name="times[]">`;
  $("#times").append(time);
}
</script>
@endsection