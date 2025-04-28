@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Edit Product</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.products.index') }}">Products</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="imageUrl" class="form-label">Image (Leave blank to keep current)</label>
                        <input type="file" name="imageUrl" id="imageUrl" class="form-control">
                        <img src="{{ asset($product->imageUrl) }}" alt="{{ $product->name }}" style="max-width: 100px; margin-top: 10px;">
                        @error('imageUrl')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="categoryId" class="form-label">Category *</label>
                        <select name="categoryId" id="categoryId" class="form-control" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->categoryId }}" {{ old('categoryId', $product->categoryId) == $category->categoryId ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoryId')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
