@extends('layouts.adminLayout.admin_design')

@section('content')
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Coupons</a> <a href="#" class="current">View Coupons</a> </div>
            <h1>Coupons</h1>
        </div>
        <div class="container-fluid">
            <hr>
            @if(Session::has('flash_message_error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_error') !!}</strong>
                </div>
            @endif

            @if(Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                            <h5>View Coupons</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered data-table">
                                <thead>
                                <tr>
                                    <th>Coupon ID</th>
                                    <th>Coupon Code</th>
                                    <th>Amount Type</th>
                                    <th>Amount</th>
                                    <th>Expiry Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($coupons as $coupon)
                                    <tr class="gradeX">
                                        <td>{{ $coupon->id }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ $coupon->amount_type }}</td>
                                        <td>{{ $coupon->amount }}</td>
                                        <td>{{ $coupon->expiry_date }}</td>
                                        <td>@if($coupon->status == 1) Active @else Inactive @endif</td>
                                        <td class="center">
                                            <a href="{{ url('/admin/edit-coupon/'.$coupon->id) }}" class="btn btn-primary btn-mini">Edit</a>
                                            <a {{--href="{{ url('/admin/delete-product/'.$product->id) }}"--}} href="javascript:" class="btn btn-danger btn-mini del-coupon" rel="{{ $coupon->id }}" rel1="delete-coupon">Delete</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
