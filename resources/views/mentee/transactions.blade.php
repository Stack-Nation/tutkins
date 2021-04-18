@extends('layouts.authApp')
@section("title","Transactions")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">Transactions</h3>
        </div>
        
    </div>
</div>

<!-- Main content -->
<section class="content">

  <div class="row">
      <div class="col-12">
        <div class="box">
          <div class="box-body">
            @if($transactions->count()>0)
            <div class="table-responsive">
                <table id="productorder" class="table table-hover no-wrap product-order" data-page-size="10">
                    <thead>
                        <tr>
                             <th>Transaction ID</th>
                             <th>Product</th>
                             <th>Type</th>
                             <th>Date</th>
                             <th>Price paid</th>
                             <th>Status</th>
                             <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <?php
                            if($transaction->item_type==="course"){
                                $item = \App\Models\Course::find($transaction->item_id);
                            }
                            elseif($transaction->item_type==="webinar"){
                                $item = \App\Models\Webinar::find($transaction->item_id);
                            }
                            elseif($transaction->item_type==="mentoring"){
                                $item = \App\Models\Mentoring::find($transaction->item_id);
                            }
                        ?>
                        <tr>
                            <td>{{$transaction->transaction_id}}</td>
                            <td>{{$item->title}}</td>
                            <td><span style="text-transform: capitalize">{{$transaction->item_type}}</span></td>
                            <td>{{\Carbon\Carbon::parse($transaction->created_at)->diffForHumans()}}</td>
                            <td>{{$transaction->amount}} INR</td>
                            <td><span class="badge badge-pill badge-success">{{$transaction->status}}</span></td>
                            <td>
                                <a href="javascript:void(0)" class="text-danger" data-original-title="Delete" data-toggle="tooltip">
                                    <i class="ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>						
                </table>
            </div>
            @else
            <p>No transactions found.</p>
            @endif
            {{$transactions->links()}}
          </div>
        </div>
      </div>		  
  </div>

</section>
<!-- /.content -->
@endsection