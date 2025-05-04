@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
    <div class="container-fluid no-print page-header py-5">
        <h1 class="text-center text-dark display-6">Order #{{ $order->orderId }}</h1>
    </div>
    <div class="container no-print">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('customer.profile') }}">My Profile</a></li>
                <li class="completed"><a href="{{ route('customer.orders') }}">My Orders</a></li>
                <li class="active"><a href="#">Order Details</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order Invoice</h5>
                    <button id="print-invoice-btn" class="btn btn-light btn-sm no-print"><i class="fa fa-print me-2"></i>Print Invoice</button>
                </div>
                <div class="card-body" id="invoice-area">
                    <!-- Invoice Header -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Website Logo" style="max-width: 150px;">
                            <h4 class="mt-2">Smart Shopping</h4>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-0"><strong>Invoice #{{ $order->orderId }}</strong></p>
                            <p class="mb-0">Date: {{ date('Y-m-d H:i A', strtotime($order->orderDate)) }}</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <h5>Customer Details</h5>
                            <p class="mb-0">{{ $order->account->fullName }}</p>
                            <p class="mb-0">{{ $order->account->email }}</p>
                            <p class="mb-0">{{ $order->account->phoneNumber ?? 'N/A' }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <h5>Order Info</h5>
                            <p class="mb-0"><strong>Order Type:</strong> {{ $order->orderType }}</p>
                            <p class="mb-0"><strong>Status:</strong> {{ $order->orderStatus }}</p>
                            <p class="mb-0"><strong>Used Points:</strong> {{ $order->usedPoints }}</p>
                        </div>
                    </div>

                    <!-- Order Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($order->orderItems as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->inventory->product->name ?? 'Unknown Product' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>SAR {{ number_format($item->soldPrice, 2) }}</td>
                                    <td>SAR {{ number_format($item->soldPrice * $item->quantity, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No items found for this order.</td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Subtotal:</td>
                                <td>SAR {{ number_format($order->orderItems->sum(fn($item) => $item->soldPrice * $item->quantity), 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Points Used:</td>
                                <td>{{ $order->usedPoints }} Points</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total Amount:</td>
                                <td>SAR {{ number_format($order->totalAmount, 2) }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Footer Note -->
                    <div class="text-center">
                        <p class="text-muted">Thank you for shopping with Smart Shopping! For support, contact us at support@smartshopping.com.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('print-invoice-btn').addEventListener('click', function () {
                window.print();
            });
        });
    </script>
@endpush
