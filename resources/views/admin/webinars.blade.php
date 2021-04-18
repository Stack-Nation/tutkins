@extends('layouts.authApp')
@section("title","Admin Webinars")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Webinars</h1>
    

    <div class="container page__container page-section">

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">

            <div class="table-responsive"
                data-toggle="lists"
                data-lists-sort-by="js-lists-values-date"
                data-lists-sort-desc="true"
                data-lists-values='["js-lists-values-lead", "js-lists-values-project", "js-lists-values-status", "js-lists-values-budget", "js-lists-values-date"]'>
                @if($webinars->count()===0)
                <p>No webinar found.</p>
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
                        @foreach ($webinars as $webinar)
                            <tr class="pr-0">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$webinar->title}}</td>
                                <td>{{$webinar->owner->email}}</td>
                                <td>{{$webinar->category->name}}</td>
                                <td>{{$webinar->form===NULL?"No":"Yes"}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$webinars->links()}}

            </div>

        </div>

    </div>
</div>
@endsection