@extends('layouts.app')
@push('css')
    <style>
        .star-rating {
            direction: rtl;
            display: inline-flex;
        }
        .star-rating input[type="radio"] {
            display: none;
        }
        .star-rating label {
            font-size: 24px;
            color: lightgray;
            cursor: pointer;
        }
        .star-rating input[type="radio"]:checked ~ label {
            color: gold;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }
    </style>

@endpush
@section('title', $inventory->product->name)

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Shop Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">shop</a></li>
            <li class="breadcrumb-item active text-white">Shop Details</li>
        </ol>
    </div>
    <div  class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{ asset($inventory->imageUrl ?? $inventory->product->imageUrl ?? 'img/default-product.jpg') }}" class="img-fluid rounded" alt="{{ $inventory->product->name }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{ $inventory->product->name }}</h4>
                            <p class="mb-3">Category: {{ optional($inventory->product->category)->name ?? 'N/A' }}</p>
                            @php
                                $price = $inventory->price;
                                $hasOffer = $inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate);
                                $originalPrice = $hasOffer ? $price / (1 - $inventory->offers->first()->discountPercentage / 100) : $price;
                            @endphp
                            <h5 class="fw-bold mb-3">
                                @if ($hasOffer)
                                    SAR {{ number_format($price, 2) }}
                                    <small class="text-muted text-decoration-line-through">SAR {{ number_format($originalPrice, 2) }}</small>
                                @else
                                    SAR {{ number_format($price, 2) }}
                                @endif
                            </h5>
                            <div class="d-flex mb-4">
                                @php
                                    $avgRating = $inventory->reviews->avg('rating') ?? 0;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $avgRating ? 'text-secondary' : '' }}"></i>
                                @endfor
                                <small class="ms-2">({{ $inventory->reviews->count() }} reviews)</small>
                            </div>
                            <p class="mb-2"><strong>Stock:</strong> {{ $inventory->quantity }} units</p>
                            <p class="mb-2"><strong>Weight:</strong> {{ $inventory->weight ? $inventory->weight . ' kg' : 'N/A' }}</p>
                            <p class="mb-2"><strong>Size:</strong> {{ $inventory->size ?? 'N/A' }}</p>
                            <p class="mb-4"><strong>Expiry Date:</strong> {{ $inventory->expiryDate ? date('F j, Y', strtotime($inventory->expiryDate)) : 'N/A' }}</p>
                            <form action="{{ route('cart.add', $inventory->inventoryId) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <form action="{{ route('cart.update', $inventory->inventoryId) }}" method="POST" class="input-group quantity mt-4" style="width: 100px;">
                                        @csrf
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="updateQuantity(this, -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="quantity" class="form-control form-control-sm text-center border-0" value="0">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="updateQuantity(this, 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                @if ($inventory->stockShelves->count())
                                    <h6>Available Shelves:</h6>
                                    <ul>
                                        @foreach ($inventory->stockShelves as $shelf)
                                            <li>{{ $shelf->location }} ({{ $shelf->quantity }} in stock)</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-danger">Not available on any shelf.</p>
                                @endif

                                <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Description</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">Reviews</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p>{{ $inventory->product->description ?? 'No detailed description available.' }}</p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Stock</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->quantity }} units</p></div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Category</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ optional($inventory->product->category)->name ?? 'N/A' }}</p></div>
                                                </div>
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Weight</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->weight ? $inventory->weight . ' kg' : 'N/A' }}</p></div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Size</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->size ?? 'N/A' }}</p></div>
                                                </div>
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Expiry Date</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->expiryDate ? date('F j, Y', strtotime($inventory->expiryDate)) : 'N/A' }}</p></div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Shelf Location</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->shelfLocation ?? 'N/A' }}</p></div>
                                                </div>
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6"><p class="mb-0">Batch Number</p></div>
                                                    <div class="col-6"><p class="mb-0">{{ $inventory->batchNumber ?? 'N/A' }}</p></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    @forelse ($inventory->reviews as $review)
                                        <div class="d-flex mb-4">
                                            <i class="fa fa-user me-2 text-primary"></i>                                            <div class="w-100">
                                                <p class="mb-2" style="font-size: 14px;">{{ date('F j, Y', strtotime($review->reviewDate)) }}</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>{{ $review->account->fullName }}</h5>
                                                    <div class="d-flex mb-3">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star {{ $i <= $review->rating ? 'text-secondary' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                                @if (Auth::check() && Auth::id() === $review->accountId)
                                                    <form action="{{ route('customer.reviews.delete', $review->reviewId) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p>No reviews yet. Be the first to review this product!</p>
                                    @endforelse

                                        <!-- Review Form -->
                                        @auth
                                            @if (!$inventory->reviews->where('accountId', Auth::id())->count())
                                                <form class="w-75 card p-3" action="{{ route('customer.reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="inventoryId" value="{{ $inventory->inventoryId }}">
                                                    <h4 class="mb-5 fw-bold">Leave a Review</h4>
                                                    <div class="row g-4">
                                                        <div class="col-lg-12">
                                                            <div class="border-bottom rounded my-4">
                                                                <textarea name="comment" class="form-control border-0 @error('comment') is-invalid @enderror" cols="4" rows="4" placeholder="Your Review *" required>{{ old('comment') }}</textarea>
                                                                @error('comment')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <!-- Rating Stars -->
                                                        <div class="col-lg-12">
                                                            @foreach ([
                                                                'product_quality_rating' => 'Product Quality',
                                                                'order_accuracy_rating' => 'Order Accuracy',
                                                                'locker_condition_rating' => 'Locker Condition',
                                                                'processing_speed_rating' => 'Processing Speed'
                                                            ] as $field => $label)
                                                                <div class="mb-4">
                                                                    <label class="form-label d-block">{{ $label }}:</label>
                                                                    <div class="star-rating" data-name="{{ $field }}">
                                                                        @for ($i = 5; $i >= 1; $i--)
                                                                            <input id="{{ $field }}-star-{{ $i }}" type="radio" name="{{ $field }}" value="{{ $i }}" {{ old($field) == $i ? 'checked' : '' }}/>
                                                                            <label for="{{ $field }}-star-{{ $i }}">&#9733;</label>
                                                                        @endfor
                                                                    </div>
                                                                    @error($field)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="col-lg-12">
                                                            <button type="submit" class="btn border border-secondary text-primary rounded-pill px-4 py-3">Post Review</button>
                                                        </div>
                                                    </div>
                                                </form>


                                            @else
                                                <p class="text-muted">You’ve already reviewed this product.</p>
                                            @endif
                                        @else
                                            <p class="text-muted">Please <a href="{{ route('login') }}">log in</a> to leave a review.</p>
                                        @endauth
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
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
