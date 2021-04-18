@extends('layouts.authApp')
@section("title","Your Mentors")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentors</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Your Mentors</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <button class="btn btn-info btn-inline mr-2" data-toggle="modal" data-target="#addModal">Add a mentor</button>
                <button class="btn btn-success btn-inline" onclick="document.getElementById('mentors').click()">Add mentors in bulk</button>
            </div>
            <div class="table-responsive">
                @if($mentors->count()===0)
                <p>No mentor found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Category</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($mentors as $mentor)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$mentor->name}}</td>
                        <td>{{$mentor->email}}</td>
                        <td>{{$mentor->category}}</td>
                        <td>
                            <form action="{{route("organisation.mentors.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$mentor->id}}">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$mentors->links()}}

            </div>

        </div>

    </div>
</div>
<form action="{{route("organisation.mentors.create.bulk")}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" name="mentors" id="mentors" accept=".xls,.xlsx" hidden onchange="this.form.submit()">
</form>
@endsection
@section('modals')
    
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add a new mentor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('organisation.mentors.create') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Mentor name ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email:</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Mentor email address ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="category">Category:</label>
                    <select name="category" class="custom-select" id="category">
                        <option value="">Select Mentor Category</option>
                        <option value="Employee">Employee</option>
                        <option value="Founder">Founder</option>
                        <option value="Core Team">Core Team</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password:</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Mentor password ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm mentor password ...">
                </div>
                <div class="text-center">
                    <button class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endsection