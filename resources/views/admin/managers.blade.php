@extends('layouts.authApp')
@section("title","Admin Managers")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Managers</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">All Managers</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#managerModal">Add a new manager</button>
            </div>

            <div class="table-responsive"
                data-toggle="lists"
                data-lists-sort-by="js-lists-values-date"
                data-lists-sort-desc="true"
                data-lists-values='["js-lists-values-lead", "js-lists-values-project", "js-lists-values-status", "js-lists-values-budget", "js-lists-values-date"]'>
                @if($users->count()===0)
                <p>No manager found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($users as $user)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    <form action="{{route("admin.manager.delete")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$user->id}}">
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

                {{$users->links()}}

            </div>

        </div>

    </div>
</div>
@endsection
@section('modals')
    
<!-- Modal -->
<div class="modal fade" id="managerModal" tabindex="-1" aria-labelledby="managerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="managerModalLabel">Add a new manager</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.manager.create') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Manager name ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Email:</label>
                    <input id="email" type="email" class="form-control" name="email" placeholder="Manager email address ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password:</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Manager password ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm Password:</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm manager password ...">
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