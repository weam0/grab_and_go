@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Inventory Item Details</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.inventories.index') }}">Inventory</a></li>
                <li class="active"><a href="#">Details</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <h4>{{ $inventory->product->name }}</h4>
                <p><strong>ID:</strong> {{ $inventory->inventoryId }}</p>
                <p><strong>Barcode:</strong> {{ $inventory->barcode }}</p>
                <p><strong>Quantity:</strong> {{ $inventory->quantity }}</p>
                <p><strong>Price:</strong> ${{ number_format($inventory->price, 2) }}</p>
                <p><strong>Size:</strong> {{ $inventory->size ?? 'N/A' }}</p>
                <p><strong>Weight:</strong> {{ $inventory->weight ? $inventory->weight . ' kg' : 'N/A' }}</p>
                <p><strong>Expiry Date:</strong> {{ $inventory->expiryDate ?? 'N/A' }}</p>
                <p><strong>Batch Number:</strong> {{ $inventory->batchNumber ?? 'N/A' }}</p>
                <p><strong>Last Update:</strong> {{ $inventory->lastUpdate ?? 'N/A' }}</p>
                <p><strong>Shelf Location:</strong> {{ $inventory->shelfLocation ?? 'N/A' }}</p>
                <p><strong>Image:</strong></p>
                @if ($inventory->imageUrl)
                    <img src="{{ asset($inventory->imageUrl) }}" alt="Inventory Image" style="max-width: 200px;">
                @else
                    <p>N/A</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('admin.inventories.edit', $inventory) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-secondary">Back to Inventory</a>
                </div>
            </div>
        </div>
    </div>
@endsection
