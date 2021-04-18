@extends('layouts.authApp')
@section("title","Tests")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Tests</div>
        </div>
        <select name="role" class="custom-select mb-3" id="role" onchange="getType(this);">
            <option value="tests" @if($type==="tests") selected @endif>Tests</option>
            <option value="groups" @if($type==="groups") selected @endif>Groups</option>
        </select>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($tests->count()===0)
                <p>No test found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                        </tr>
                    </thead>
                    <tbody class="list">
                    @foreach ($tests as $test)
                    <tr class="pr-0">
                        <td>{{$loop->iteration}}</td>
                        <td><img src="{{asset("assets/tests/image/".$test->image)}}" height="50px" width="50px" alt="{{$test->title}} logo"/></td>
                        <td>{{$test->title}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$tests->links()}}

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
            @if(Auth::user()->role==="Admin")
            location.href = "{{route('admin.tests')}}"
            @else
            location.href = "{{route('manager.tests')}}"
            @endif
        }
        else if(val==="groups"){
            @if(Auth::user()->role==="Admin")
            location.href = "{{route('admin.tests.groups')}}"
            @else
            location.href = "{{route('manager.tests.groups')}}"
            @endif
        }
    }
</script>
@endsection