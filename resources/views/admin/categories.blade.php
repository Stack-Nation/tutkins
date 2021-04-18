@extends('layouts.authApp')
@section("title","Admin Categories")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Categories</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">All Categories</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">Add a new category</button>
            </div>

            <div class="table-responsive"
                data-toggle="lists"
                data-lists-sort-by="js-lists-values-date"
                data-lists-sort-desc="true"
                data-lists-values='["js-lists-values-lead", "js-lists-values-project", "js-lists-values-status", "js-lists-values-budget", "js-lists-values-date"]'>
                @if($categories->count()===0)
                <p>No category found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($categories as $category)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td><img src="{{asset("assets/categories/icon/".$category->icon)}}" height="50px" width="50px" alt="{{$category->name}} logo"/></td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <form action="{{route("admin.category.delete")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$category->id}}">
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

                {{$categories->links()}}

            </div>

        </div>

    </div>
</div>
@endsection
@section('modals')
    
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="categoryModalLabel">Add a new category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.category.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Name:</label>
                    <input id="name" type="text" class="form-control" name="name" placeholder="Category name ...">
                </div>
                <div class="form-group">
                    <label class="form-label" for="icon">Icon:</label>
                    <input id="icon" type="file" class="custom-file" name="icon">
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