@extends('layouts.app')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Smart Cart Simulation</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">Smart Cart Simulation</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Smart Cart Simulation Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4">
                <!-- Barcode Scanner Simulation -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Simulate Barcode Scanner</h5>


                        </div>
                        <div class="card-body">
                            <form id="barcodeForm" action="{{ route('smart-cart-simulation.add') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="text" name="barcode" class="form-control" placeholder="Enter Barcode (e.g., 123456789)" required>
                                    <button type="submit" class="btn btn-primary">Scan</button>
                                </div>
                            </form>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <p class="text-muted">Enter a barcode to simulate adding an item to the smart cart.</p>
                        </div>
                    </div>
                </div>

                <!-- Simulated Cart Display -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Simulated Cart</h5>
                        </div>
                        <div class="card-body">
                            @if (empty($cartItems))
                                <p class="text-center">No items in the simulated cart.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $cartSubtotal = 0;
                                        @endphp
                                        @foreach ($cartItems as $item)
                                            @php
                                                $inventory = $item['inventory'];
                                                $quantity = $item['quantity'];
                                                $price = $inventory->price;
                                                $originalPrice = $price;
                                                $hasOffer = $inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate);
                                                if ($hasOffer) {
                                                    $discountPercentage = $inventory->offers->first()->discountPercentage;
                                                    $originalPrice = $price / (1 - $discountPercentage / 100); // Assuming price is discounted
                                                }
                                                $subtotal = $price * $quantity;
                                                $cartSubtotal += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $inventory->product->name }}</td>
                                                <td>
                                                    @if ($hasOffer)
                                                        SAR {{ number_format($price, 2) }}
                                                        <span class="text-danger text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</span>
                                                    @else
                                                        SAR {{ number_format($price, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('smart-cart-simulation.update', $inventory->inventoryId) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="number" name="quantity" value="{{ $quantity }}" min="1" class="form-control d-inline" style="width: 80px;" onchange="this.form.submit()">
                                                    </form>
                                                </td>
                                                <td>
                                                    @if ($hasOffer)
                                                        SAR {{ number_format($subtotal, 2) }}
                                                        <span class="text-danger text-decoration-line-through">SAR {{ number_format($originalPrice * $quantity, 2) }}</span>
                                                    @else
                                                        SAR {{ number_format($subtotal, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('smart-cart-simulation.remove', $inventory->inventoryId) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <h5>Subtotal: SAR {{ number_format($cartSubtotal, 2) }}</h5>
                                    <h5>Total: SAR {{ number_format($cartSubtotal, 2) }}</h5>
                                    <a href="{{ route('smart-cart-simulation.clear') }}" class="btn btn-warning mt-2" onclick="return confirm('Clear the simulated cart?')">Clear Cart</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Smart Cart Simulation End -->
@endsection
{{--                <!-- Left: Product List and Search -->--}}
{{--                <div class="col-lg-8">--}}
{{--                    <div class="card border-0 shadow-sm">--}}
{{--                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">--}}
{{--                            <h5 class="mb-0">Available Products</h5>--}}
{{--                            <form action="{{ route('customer.smart-cart') }}" method="GET" class="d-flex">--}}
{{--                                <input type="text" name="search" class="form-control me-2" placeholder="Search products..." value="{{ request('search') }}">--}}
{{--                                <button type="submit" class="btn btn-light"><i class="fa fa-search"></i></button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row g-4">--}}
{{--                                @forelse ($inventoryItems as $item)--}}
{{--                                    @php--}}
{{--                                        $product = $item->product;--}}
{{--                                        $price = $item->price;--}}
{{--                                        $hasOffer = $item->offers->isNotEmpty() && now()->between($item->offers->first()->startDate, $item->offers->first()->endDate);--}}
{{--                                        $originalPrice = $hasOffer ? $price / (1 - $item->offers->first()->discountPercentage / 100) : $price;--}}
{{--                                    @endphp--}}
{{--                                    <div class="col-md-6 col-lg-4">--}}
{{--                                        <div class="rounded position-relative fruite-item shadow-sm">--}}
{{--                                            <div class="fruite-img">--}}
{{--                                                <img style="    height: 273px;"  src="{{ asset($item->imageUrl ?? 'assets/img/default-product.jpg') }}" class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">--}}
{{--                                            </div>--}}
{{--                                            @if ($hasOffer)--}}
{{--                                                <div class="text-white bg-danger px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Offer</div>--}}
{{--                                            @endif--}}
{{--                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">--}}
{{--                                                <h5>{{ $product->name }}</h5>--}}
{{--                                                <p>{{ Str::limit($product->description ?? 'No description available', 50) }}</p>--}}
{{--                                                <div class="d-flex justify-content-between flex-column align-items-center">--}}
{{--                                                    <p class="text-dark fs-5 fw-bold mb-0 " style="    font-size: 14px !important;--}}
{{--    padding-bottom: 17px;">--}}
{{--                                                        @if ($hasOffer)--}}
{{--                                                            SAR {{ number_format($price, 2) }}--}}
{{--                                                            <small class="text-danger text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</small>--}}
{{--                                                        @else--}}
{{--                                                            SAR {{ number_format($price, 2) }}--}}
{{--                                                        @endif--}}
{{--                                                    </p>--}}
{{--                                                    <form action="{{ route('customer.smart-cart.add', $item->inventoryId) }}" method="POST" class="d-inline">--}}
{{--                                                        @csrf--}}
{{--                                                        <button style="font-size: 12px;" type="submit" class="btn btn-primary btn-sm">--}}
{{--                                                            <i class="fa fa-shopping-cart me-2"></i> Add to Smart Cart--}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @empty--}}
{{--                                    <div class="col-12 text-center">--}}
{{--                                        <p>No products found.</p>--}}
{{--                                    </div>--}}
{{--                                @endforelse--}}
{{--                            </div>--}}
{{--                            <div class="mt-4">--}}
{{--                                {{ $inventoryItems->appends(['search' => request('search')])->links() }}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
