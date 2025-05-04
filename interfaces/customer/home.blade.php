@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Start -->
    <div class="container-fluid py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-md-12 col-lg-7">
                    <h4 class="mb-3 text-secondary">Fast. Convenient. Smart.</h4>
                    <h1 class="mb-5 display-3 text-primary">Smart Shopping Cart</h1>
                    <p class="mb-4">Experience a new way to shop with our innovative smart cart technology. Scan, weigh, and pay directly from your cart—no more long lines or delays!</p>
                    <div class="position-relative mx-auto">
                       <form method="get" action="{{route('shop')}}">
                           <input name="search" class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="text" placeholder="Search for products">
                           <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Find Now</button>
                       </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active rounded">
                                <img src="{{ asset('assets/img/hero-img-1.png') }}" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Start Shopping</a>
                            </div>
                            <div class="carousel-item rounded">
                                <img src="{{ asset('assets/img/hero-img-2.jpg') }}" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                <a href="#" class="btn px-4 py-2 text-white rounded">Easy Checkout</a>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Features Section Start -->
    <div class="container-fluid featurs py-4">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Why Choose Grab and go?</h1>
                <p>Say goodbye to long checkout lines and hello to a seamless, tech-savvy shopping experience.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-barcode fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Barcode Scanning</h5>
                            <p class="mb-0">Easily scan products with smart cart technology.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-weight fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Automatic Weighing</h5>
                            <p class="mb-0">Sensors ensure accurate billing every time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-credit-card fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Integrated Payments</h5>
                            <p class="mb-0">Pay with cards, e-wallets, or QR codes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="featurs-item text-center rounded bg-light p-4">
                        <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                            <i class="fas fa-map-marked-alt fa-3x text-white"></i>
                        </div>
                        <div class="featurs-content text-center">
                            <h5>Supermarket Map</h5>
                            <p class="mb-0">Navigate the store with ease.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features Section End -->
    <!-- Products Section Start -->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Explore Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-all">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>
                            <!-- Add more category tabs if you have categories in your Product model -->
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-featured">
                                    <span class="text-dark" style="width: 130px;">Featured</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <!-- Tab: All Products -->
                    <div id="tab-all" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @forelse ($inventoryItems as $item)
                                        @php
                                            $product = $item->product;
                                            $price = $item->price;
                                            $hasOffer = $item->offers->isNotEmpty() && now()->between($item->offers->first()->startDate, $item->offers->first()->endDate);
                                            $originalPrice = $hasOffer ? $price / (1 - $item->offers->first()->discountPercentage / 100) : $price;
                                        @endphp
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative fruite-item shadow-sm">
                                                <div class="fruite-img">
                                                    <img style="    height: 273px;"  src="{{ asset($item->imageUrl) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                                                </div>
                                                @if ($hasOffer)
                                                    <div class="text-white bg-danger px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Offer</div>
                                                @endif
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>{{ $product->name }}</h4>
                                                    <p>{{ Str::limit($product->description ?? 'No description available', 50) }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">
                                                            @if ($hasOffer)
                                                                SAR {{ number_format($price, 2) }}
                                                                <small class="text-muted text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</small>
                                                            @else
                                                                SAR {{ number_format($price, 2) }}
                                                            @endif
                                                        </p>
                                                        <form action="{{ route('cart.add', $item->inventoryId) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                                <i class="fa fa-shopping-cart me-2 text-primary"></i> Add to Cart
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>No products available at the moment.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab: Featured Products (example filter) -->
                    <div id="tab-featured" class="tab-pane fade p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @forelse ($inventoryItems->where('price', '>', 50) as $item) <!-- Example filter for "featured" -->
                                    @php
                                        $product = $item->product;
                                        $price = $item->price;
                                        $hasOffer = $item->offers->isNotEmpty() && now()->between($item->offers->first()->startDate, $item->offers->first()->endDate);
                                        $originalPrice = $hasOffer ? $price / (1 - $item->offers->first()->discountPercentage / 100) : $price;
                                    @endphp
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative fruite-item shadow-sm">
                                            <div class="fruite-img">
                                                <img src="{{ asset($item->imageUrl) }}" class="img-fluid w-100 rounded-top" alt="{{ $product->name }}">
                                            </div>
                                            @if ($hasOffer)
                                                <div class="text-white bg-danger px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Offer</div>
                                            @endif
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ $product->name }}</h4>
                                                <p>{{ Str::limit($product->description ?? 'No description available', 50) }}</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                        @if ($hasOffer)
                                                            SAR {{ number_format($price, 2) }}
                                                            <small class="text-muted text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</small>
                                                        @else
                                                            SAR {{ number_format($price, 2) }}
                                                        @endif
                                                    </p>
                                                    <form action="{{ route('cart.add', $item->inventoryId) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                            <i class="fa fa-shopping-cart me-2 text-primary"></i> Add to Cart
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <p>No featured products available.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products Section End -->
@endsection
