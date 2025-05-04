@extends('layouts.app')

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Shop Now</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white">shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    <div class="container-fluid fruite py-2">
        <div class="container py-2">
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <form action="{{ route('shop') }}" method="GET" id="searchForm">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" name="search" class="form-control p-3" placeholder="Keywords" value="{{ request('search') }}" aria-describedby="search-icon-1">
                                    <button type="submit" id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="sort">Default Sorting:</label>
                                <select id="sort" name="sort" class="border-0 form-select-sm bg-light me-3" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Nothing</option>
                                    <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="{{ route('shop', array_merge(request()->query(), ['category' => $category->categoryId])) }}">
                                                            <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                                        </a>
{{--                                                        <span>({{ $category->products->count() }})</span>--}}
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Price</h4>
                                        <form action="{{ route('shop') }}" method="GET" id="priceForm">
                                            <input type="range" class="form-range w-100" id="rangeInput" name="max_price" min="0" max="10000" value="{{ request('max_price', 10000) }}" oninput="amount.value=rangeInput.value" onchange="document.getElementById('priceForm').submit()">
                                            <output id="amount" name="amount" for="rangeInput">{{ request('max_price', 500) }}</output>
                                            @foreach (request()->except('max_price') as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endforeach
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Offers</h4>
                                        <form action="{{ route('shop') }}" method="GET" id="filterForm">
                                            <div class="mb-2">
                                                <input type="checkbox" class="me-2" id="offers" name="offers" value="1" {{ request('offers') ? 'checked' : '' }} onchange="this.form.submit()">
                                                <label for="offers">Show only items with active offers</label>
                                            </div>
                                            @foreach (request()->except('offers') as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                            @endforeach
                                        </form>
                                    </div>
                                </div>

{{--                                <div class="col-lg-12">--}}
{{--                                    <div class="mb-3">--}}
{{--                                        <h4>Rating</h4>--}}
{{--                                        <form action="{{ route('shop') }}" method="GET" id="ratingForm">--}}
{{--                                            <select name="rating" id="rating" class="form-control" onchange="this.form.submit()">--}}
{{--                                                <option value="">All Ratings</option>--}}
{{--                                                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star & Up</option>--}}
{{--                                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars & Up</option>--}}
{{--                                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars & Up</option>--}}
{{--                                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars & Up</option>--}}
{{--                                                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>--}}
{{--                                            </select>--}}
{{--                                            @foreach (request()->except('rating') as $key => $value)--}}
{{--                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">--}}
{{--                                            @endforeach--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-lg-12">
                                    <h4 class="mb-3">Featured Products</h4>
                                    @foreach ($featuredProducts as $inventory)
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                <img src="{{ asset($inventory->imageUrl) }}" class="img-fluid rounded" alt="{{ $inventory->product->name }}">
                                            </div>
                                            <div>
                                                <h6 class="mb-2">{{ $inventory->product->name }}</h6>

                                                <div class="d-flex mb-2">
                                                    <p class=" me-2">{{ number_format($inventory->price, 2) }} SAR</p>
                                                    @if ($inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate))
                                                        <p class="text-danger text-decoration-line-through">{{ number_format($inventory->price / (1 - $inventory->offers->first()->discountPercentage / 100), 2) }} SAR</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
{{--                                    <div class="d-flex justify-content-center my-4">--}}
{{--                                        <a href="{{ route('shop') }}" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">View More</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4">
                                @forelse ($inventories as $inventory)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img style="    height: 273px;" src="{{ asset($inventory->imageUrl) }}" class="img-fluid w-100 rounded-top" alt="{{ $inventory->product->name }}">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                @if ($inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate))
                                                    <p class="text-white fs-9 fw-bold mb-0">
                                                        SAR {{ number_format($inventory->price, 2) }}
                                                        <span class="text-danger text-decoration-line-through">SAR {{ number_format($inventory->price / (1 - $inventory->offers->first()->discountPercentage / 100), 2) }}</span>
                                                    </p>
                                                @else
                                                    <p class="text-white fs-9  mb-0">SAR {{ number_format($inventory->price, 2) }}</p>
                                                @endif
                                            </div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{ optional($inventory->product)->name }}</h4>
                                                <p>Category : {{optional($inventory->product->category)->name}}</p>
                                                <div class="d-flex mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star {{ $i <= 4 ? 'text-secondary' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <form action="{{ route('cart.add', $inventory->inventoryId) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart</button>
                                                        <a href="{{route('product.show', $inventory->inventoryId)}}" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-eye me-2 text-primary"></i> View</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <p>No products found.</p>
                                    </div>
                                @endforelse
                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <!-- Previous Button -->
                                            @if ($inventories->onFirstPage())
                                                <a href="#" class="rounded disabled">«</a>
                                            @else
                                                <a href="{{ $inventories->previousPageUrl() }}" class="rounded">«</a>
                                            @endif

                                            <!-- Page Numbers -->
                                            @php
                                                $currentPage = $inventories->currentPage();
                                                $lastPage = $inventories->lastPage();
                                                $startPage = max(1, $currentPage - 2);
                                                $endPage = min($lastPage, $currentPage + 2);

                                                if ($endPage - $startPage < 4) {
                                                    if ($startPage == 1) {
                                                        $endPage = min(5, $lastPage);
                                                    } else {
                                                        $startPage = max(1, $endPage - 4);
                                                    }
                                                }
                                            @endphp

                                            @for ($i = $startPage; $i <= $endPage; $i++)
                                                <a href="{{ $inventories->url($i) }}" class="rounded {{ $currentPage == $i ? 'active' : '' }}">{{ $i }}</a>
                                            @endfor

                                            <!-- Next Button -->
                                            @if ($inventories->hasMorePages())
                                                <a href="{{ $inventories->nextPageUrl() }}" class="rounded">»</a>
                                            @else
                                                <a href="#" class="rounded disabled">»</a>
                                            @endif
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
