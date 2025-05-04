@extends('layouts.app')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (empty($cartItems))
                <div class="text-center">
                    <p>Your cart is empty.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $cartSubtotal = 0; // To calculate the total with discounts
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
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($inventory->product->imageUrl) }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="{{ $inventory->product->name }}">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $inventory->product->name }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">
                                        @if ($hasOffer)
                                            SAR {{ number_format($price, 2) }}
                                            <span class="text-danger text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</span>
                                        @else
                                            SAR {{ number_format($price, 2) }}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.update', $inventory->inventoryId) }}" method="POST" class="input-group quantity mt-4" style="width: 100px;">
                                        @csrf
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="updateQuantity(this, -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="quantity" class="form-control form-control-sm text-center border-0" value="{{ $quantity }}">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="updateQuantity(this, 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">
                                        @if ($hasOffer)
                                            SAR {{ number_format($subtotal, 2) }}
                                            <span class="text-danger text-decoration-line-through">SAR {{ number_format($originalPrice * $quantity, 2) }}</span>
                                        @else
                                            SAR {{ number_format($subtotal, 2) }}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $inventory->inventoryId) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-md rounded-circle bg-light border mt-4" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">SAR {{ number_format($cartSubtotal, 2) }}</p>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4">SAR {{ number_format($cartSubtotal, 2) }}</p>
                            </div>
                            <a href="{{ route('customer.checkout') }}" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">Proceed Checkout</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@push('js')
    <script>
        function updateQuantity(button, change) {
            const form = button.closest('form');
            const input = form.querySelector('input[name="quantity"]');
            let quantity = parseInt(input.value) || 0;
            quantity += change;
            if (quantity < 1) quantity = 1;
            console.log('New quantity:', quantity);
            input.value = quantity;
            form.submit();
        }
    </script>
@endpush
