@extends('layouts.customer')

@section('title', 'Home')

@section('content')
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Welcome Back, {{ Auth::user()->fullName }}!</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">Overview</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 130px;">Recent Orders</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 130px;">Popular Products</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                    <span class="text-dark" style="width: 130px;">Your Stats</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <!-- Tab 1: Overview -->
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset('assets/img/fruite-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="Recent Orders">
                                            </div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Orders</div>
                                            <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                <h4>Recent Orders</h4>
                                                <p>Check your latest shopping activity.</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $recentOrders->count() }} New</p>
                                                    <a href="{{ route('customer.orders') }}" class="btn border border-primary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View All</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset('assets/img/fruite-item-2.jpg') }}" class="img-fluid w-100 rounded-top" alt="Popular Products">
                                            </div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Products</div>
                                            <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                <h4>Popular Products</h4>
                                                <p>Explore trending items in the store.</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $popularProducts->count() }} Top</p>
                                                    <a href="#tab-3" class="btn border border-primary rounded-pill px-3 text-primary" data-bs-toggle="pill"><i class="fa fa-info-circle me-2 text-primary"></i> See More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset('assets/img/fruite-item-4.jpg') }}" class="img-fluid w-100 rounded-top" alt="Stats">
                                            </div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Stats</div>
                                            <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                <h4>Your Stats</h4>
                                                <p>Track your shopping and rewards.</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $totalOrders }} Orders</p>
                                                    <a href="#tab-4" class="btn border border-primary rounded-pill px-3 text-primary" data-bs-toggle="pill"><i class="fa fa-chart-line me-2 text-primary"></i> Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Recent Orders -->
                    <div id="tab-2" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @forelse ($recentOrders as $order)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item shadow-sm">
                                                <div class="fruite-img">
                                                    <img src="{{ asset('assets/img/fruite-item-5.jpg') }}" class="img-fluid w-100 rounded-top" alt="Order #{{ $order->orderId }}">
                                                </div>
                                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Order</div>
                                                <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                    <h4>Order #{{ $order->orderId }}</h4>
                                                    <p>{{ date('Y-m-d', strtotime($order->orderDate)) }} - SAR {{ number_format($order->totalAmount, 2) }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">{{ $order->orderStatus }}</p>
                                                        <a href="{{ route('customer.orders.show', $order->orderId) }}" class="btn border border-primary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>No recent orders found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Popular Products -->
                    <div id="tab-3" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @forelse ($popularProducts as $product)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item shadow-sm">
                                                <div class="fruite-img">
                                                    <img src="{{ asset($product->product->imageUrl ?? 'assets/img/fruite-item-2.jpg') }}" class="img-fluid w-100 rounded-top" alt="{{ $product->product->name }}">
                                                </div>
                                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Product</div>
                                                <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                    <h4>{{ $product->product->name }}</h4>
                                                    <p>SAR {{ number_format($product->price, 2) }} - {{ $product->total_sold }} sold</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">Top Seller</p>
                                                        <a href="#" class="btn border border-primary rounded-pill px-3 text-primary"><i class="fa fa-shopping-cart me-2 text-primary"></i> Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>No popular products found.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Your Stats -->
                    <div id="tab-4" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset('assets/img/fruite-item-4.jpg') }}" class="img-fluid w-100 rounded-top" alt="Total Orders">
                                            </div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Stats</div>
                                            <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                <h4>Total Orders</h4>
                                                <p>You’ve placed {{ $totalOrders }} orders with us.</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $totalOrders }}</p>
                                                    <a href="{{ route('customer.orders') }}" class="btn border border-primary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View Orders</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset('assets/img/fruite-item-3.jpg') }}" class="img-fluid w-100 rounded-top" alt="Reward Points">
                                            </div>
                                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Rewards</div>
                                            <div class="p-4 border border-primary border-top-0 rounded-bottom">
                                                <h4>Reward Points</h4>
                                                <p>You’ve earned {{ $totalPoints }} points so far.</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">{{ $totalPoints }} Pts</p>
                                                    <a href="#" class="btn border border-primary rounded-pill px-3 text-primary"><i class="fa fa-gift me-2 text-primary"></i> Redeem</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
