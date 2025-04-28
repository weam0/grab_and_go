@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Orders</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Orders</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($orders->isEmpty())
                <p class="text-center">No orders found.</p>
            @else
                <div class="">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->orderId }}</td>
                                        <td>{{ $order->account->fullName }}</td>
                                        <td>{{ date('Y-m-d H:i A', strtotime($order->orderDate)) }}</td>
                                        <td>SAR {{ number_format($order->totalAmount, 2) }}</td>
                                        <td>{{ $order->orderStatus }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->orderId) }}" class="btn btn-sm btn-primary">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
