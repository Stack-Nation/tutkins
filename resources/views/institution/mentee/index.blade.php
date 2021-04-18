@extends('layouts.authApp')
@section("title","Your Mentees")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentees</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Your Mentees</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <button class="btn btn-info btn-inline mr-2" data-toggle="modal" data-target="#addModal">Add a mentee</button>
                <button class="btn btn-success btn-inline" onclick="document.getElementById('mentees').click()">Add mentees in bulk</button>
            </div>
            <div class="table-responsive">
                @if($mentees->count()===0)
                <p>No mentee found.</p>
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
                    @foreach ($mentees as $mentee)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$mentee->name}}</td>
                        <td>{{$mentee->email}}</td>
                        <td>{{$mentee->category}}</td>
                        <td>
                            <form action="{{route("institution.mentees.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$mentee->id}}">
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

                {{$mentees->links()}}

            </div>

        </div>

    </div>
</div>
<form action="{{route("institution.mentees.create.bulk")}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="file" name="mentees" id="mentees" accept=".xls,.xlsx" hidden onchange="this.form.submit()">
</form>
@endsection
@section('modals')
    
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add a new mentee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('institution.mentees.create') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Mentee name ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email:</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Mentee email address ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="category">Category:</label>
                    <select name="category" class="custom-select" id="category">
                        <option value="">Select Mentee Category</option>
                        <option value="Student">Student</option>
                        <option value="Alumini">Alumini</option>
                        <option value="Teacher">Teacher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password:</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Mentee password ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm mentee password ...">
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