@extends('layouts.admin')

@section('content')
    <!-- Dashboard Content -->
    <div class="container-fluid py-1">
        <div class="container py-1">
            <!-- Welcome, Section -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card shadow-sm border-0 p-4">
                        <h2>Welcome, {{ Auth::user()->fullName }}!</h2>
                        <p>Manage the Smart Shopping Cart system efficiently from your admin dashboard.</p>
                    </div>
                </div>
            </div>

            <!-- Stat Boxes -->
            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 p-4 bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x text-primary me-3"></i>
                            <div>
                                <h6>Total Users</h6>
                                <p class="display-6 mb-0">{{ $totalUsers }}</p>
                                <small class="text-muted">users</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 p-4 bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shopping-cart fa-2x text-primary me-3"></i>
                            <div>
                                <h6>Pending Orders</h6>
                                <p class="display-6 mb-0">{{ $pendingOrders }}</p>
                                <small class="text-muted">{{ $awaitingApproval }} awaiting approval</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 p-4 bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle fa-2x text-primary me-3"></i>
                            <div>
                                <h6>Complaints</h6>
                                <p class="display-6 mb-0">{{ $totalComplaints }}</p>
                                <small class="text-muted">{{ $unresolvedComplaints }} unresolved</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 p-4 bg-light">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-box fa-2x text-primary me-3"></i>
                            <div>
                                <h6>Products</h6>
                                <p class="display-6 mb-0">{{ $totalProducts }}</p>
                                <small class="text-muted">{{ $lowStockItems }} low stock</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 p-4">
                        <h4 class="text-primary">Sales Overview (Last 6 Months)</h4>
                        <div id="salesChart" style="height: 300px;"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const options = {
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Sales (SAR)',
                    data: @json($salesValues)
                }],
                xaxis: {
                    categories: @json($salesLabels),
                    title: {
                        text: 'Month'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Amount (SAR)'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                colors: ['#5edf31'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#salesChart"), options);
            chart.render();
        });
    </script>
@endpush
