@extends('layouts.customer')

@section('title', 'My Orders')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">My Orders</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('customer.profile') }}">My Profile</a></li>
                <li class="active"><a href="#">My Orders</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container">
            @if ($orders->isEmpty())
                <p class="text-center">You have no orders yet.</p>
            @else
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>#{{ $order->orderId }}</td>
                                        <td>{{ date('Y-m-d H:i A', strtotime($order->orderDate)) }}</td>
                                        <td>SAR {{ number_format($order->totalAmount, 2) }}</td>
                                        <td>{{ $order->orderStatus }}</td>
                                        <td>
                                            <a href="{{ route('customer.orders.show', $order->orderId) }}" class="btn btn-sm btn-primary me-1">View</a>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#complaintModal{{ $order->orderId }}">Add Complaint</button>
                                        </td>
                                    </tr>

                                    <!-- Complaint Modal -->
                                    <div class="modal fade" id="complaintModal{{ $order->orderId }}" tabindex="-1" aria-labelledby="complaintModalLabel{{ $order->orderId }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="complaintModalLabel{{ $order->orderId }}">Add Complaint for Order #{{ $order->orderId }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('customer.complaints.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="orderId" value="{{ $order->orderId }}">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="description{{ $order->orderId }}" class="form-label">Complaint Description</label>
                                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description{{ $order->orderId }}" name="description" rows="4" required>{{ old('description') }}</textarea>
                                                            @error('description')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit Complaint</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
