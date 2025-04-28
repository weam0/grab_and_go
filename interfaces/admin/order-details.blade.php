@extends('layouts.admin')

@section('title', 'Order Details - #' . $order->orderId)

@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Order Details - #{{ $order->orderId }}</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.orders') }}">Orders</a></li>
                <li class="active"><a href="#">Order Details - #{{ $order->orderId }}</a></li>
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

            <div class="row g-4">
                <!-- Order Summary -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Order ID:</strong> #{{ $order->orderId }}</p>
                            <p><strong>Customer:</strong> {{ $order->account->fullName }}</p>
                            <p><strong>Date:</strong> {{ date('Y-m-d H:i A', strtotime($order->orderDate)) }}</p>
                            <p><strong>Type:</strong> {{ $order->orderType }}</p>
                            <p><strong>Status:</strong> {{ $order->orderStatus }}</p>
                            <p><strong>Total Amount:</strong> SAR {{ number_format($order->totalAmount, 2) }}</p>
                            <p><strong>Used Points:</strong> {{ $order->usedPoints }}</p>
                            @if ($order->payment)
                                <p><strong>Payment Method:</strong> {{ $order->payment->paymentMethod }}</p>
                                <p><strong>Payment Status:</strong> {{ $order->payment->transactionStatus }}</p>
                                <p><strong>Payment Date:</strong> {{ date('Y-m-d H:i A', strtotime($order->payment->paymentDate)) }}</p>
                                @if ($order->payment->cardNumber)
                                    <p><strong>Card Ending:</strong> **** {{ $order->payment->cardNumber }}</p>
                                @endif
                            @else
                                <p><strong>Payment:</strong> Not processed</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Items</h5>
                        </div>
                        <div class="card-body">
                            @if ($order->orderItems->isEmpty())
                                <p>No items found in this order.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->inventory->product->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>SAR {{ number_format($item->soldPrice, 2) }}</td>
                                                <td>SAR {{ number_format($item->soldPrice * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
            </div>
        </div>
    </div>
@endsection
