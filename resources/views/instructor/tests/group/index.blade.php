@extends('layouts.authApp')
@section("title","Your Test Groups")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Test Groups</div>
        </div>
        <select name="role" class="custom-select mb-3" id="role" onchange="getType(this);">
            <option value="tests" @if($type==="tests") selected @endif>Tests</option>
            <option value="groups" @if($type==="groups") selected @endif>Groups</option>
        </select>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.tests.groups.create")}}" class="btn btn-primary">Create new test group</a>
            </div>
            <div class="table-responsive">
                @if($groups->count()===0)
                <p>No test group found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($groups as $group)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td><img src="{{asset("assets/test_groups/image/".$group->image)}}" height="50px" width="50px" alt="{{$group->title}} logo"/></td>
                        <td>{{$group->title}}</td>
                        <td>
                            <form action="{{route("instructor.tests.groups.delete")}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$group->id}}">
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

                {{$groups->links()}}

            </div>

        </div>

    </div>
</div>
@endsection
@section('scripts')
<script>
    function getType(obj){
        const val = $(obj).val();
        if(val==="tests"){
            location.href = "{{route('instructor.tests')}}"
        }
        else if(val==="groups"){
            location.href = "{{route('instructor.tests.groups')}}"
        }
    }
</script>
@endsection