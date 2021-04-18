@extends('layouts.authApp')
@section("title","Admin Mentoring Programs")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentoring Programs</h1>
    

    <div class="container page__container page-section">


        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">

            <div class="table-responsive"
                data-toggle="lists"
                data-lists-sort-by="js-lists-values-date"
                data-lists-sort-desc="true"
                data-lists-values='["js-lists-values-lead", "js-lists-values-project", "js-lists-values-status", "js-lists-values-budget", "js-lists-values-date"]'>
                @if($mentorings->count()===0)
                <p>No mentoring program found.</p>
                @else
                <table class="table mb-0 thead-border-top-0 table-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Owner Email</th>
                            <th>Category</th>
                            <th>Form Added</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="list">
                        @foreach ($mentorings as $mentoring)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$mentoring->title}}</td>
                                <td>{{$mentoring->owner->email}}</td>
                                <td>{{$mentoring->category->name}}</td>
                                <td>{{$mentoring->form===NULL?"No":"Yes"}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$mentorings->links()}}

            </div>

        </div>

    </div>
</div>
@endsection