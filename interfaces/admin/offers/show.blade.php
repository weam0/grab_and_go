@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Offer Details</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
                <li class="active"><a href="#">Details</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <h4>Offer #{{ $offer->offerId }}</h4>
                <p><strong>Inventory Item:</strong> {{ $offer->inventory->product->name }} ({{ $offer->inventory->barcode }})</p>
                <p><strong>Start Date:</strong> {{ $offer->startDate }}</p>
                <p><strong>End Date:</strong> {{ $offer->endDate }}</p>
                <p><strong>Discount Percentage:</strong> {{ $offer->discountPercentage }}%</p>
                <div class="mt-4">
                    <a href="{{ route('admin.offers.edit', $offer) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">Back to Offers</a>
                </div>
            </div>
        </div>
    </div>
@endsection
