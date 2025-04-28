@extends('layouts.admin')

@section('title', 'Business Report')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Overview Report</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Overview Report</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <!-- Date Filter Form -->
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}" required>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sales Summary -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Sales Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6>Total Sales</h6>
                            <p class="display-6">SAR {{ number_format($salesData->total_sales ?? 0, 2) }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Number of Orders</h6>
                            <p class="display-6">{{ $salesData->order_count ?? 0 }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Average Order Value</h6>
                            <p class="display-6">SAR {{ number_format($salesData->avg_order_value ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Statistics -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Order Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Orders by Status</h6>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ordersByStatus as $status => $count)
                                    <tr>
                                        <td>{{ $status }}</td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Top 5 Customers</h6>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Total Spent (SAR)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->fullName }}</td>
                                        <td>{{ number_format($customer->total_spent, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaint Trends -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Complaints</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <h6>Total Complaints</h6>
                            <p class="display-6">{{ $totalComplaints }}</p>
                        </div>
                        <div class="col-md-8">
                            <h6>Complaints by Status</h6>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($complaintsByStatus as $status => $count)
                                    <tr>
                                        <td>{{ $status }}</td>
                                        <td>{{ $count }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Status -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-white">Inventory Status</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Summary</h6>
                            <p><strong>Total Products:</strong> {{ $totalProducts }}</p>
                            <p><strong>Low Stock Items:</strong> {{ $lowStockItems }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Top 5 Selling Products</h6>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Units Sold</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($topSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->total_sold }}</td>
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
