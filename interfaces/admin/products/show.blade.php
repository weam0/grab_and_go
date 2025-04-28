@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Product Details</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="active"><a href="#">Details</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <h4>{{ $product->name }}</h4>
                <p><strong>ID:</strong> {{ $product->productId }}</p>
                <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p><strong>Image:</strong></p>
                <img src="{{ asset($product->imageUrl) }}" alt="{{ $product->name }}" style="max-width: 200px;">
                <div class="mt-4">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
@endsection
