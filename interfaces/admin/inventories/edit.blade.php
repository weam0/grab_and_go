@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Edit Inventory Item</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.inventories.index') }}">Inventory</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('admin.inventories.update', $inventory) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
               <div class="row">
                   <div class="mb-4 col-md-6">
                       <label for="productId" class="form-label">Product *</label>
                       <select name="productId" id="productId" class="form-control" required>
                           <option value="">Select a product</option>
                           @foreach ($products as $product)
                               <option value="{{ $product->productId }}" {{ old('productId', $inventory->productId) == $product->productId ? 'selected' : '' }}>
                                   {{ $product->name }}
                               </option>
                           @endforeach
                       </select>
                       @error('productId')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="barcode" class="form-label">Barcode *</label>
                       <input type="text" name="barcode" id="barcode" class="form-control" value="{{ old('barcode', $inventory->barcode) }}" required>
                       @error('barcode')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="quantity" class="form-label">Quantity *</label>
                       <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $inventory->quantity) }}" min="0" required>
                       @error('quantity')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="price" class="form-label">Price ($) *</label>
                       <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $inventory->price) }}" min="0" required>
                       @error('price')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="size" class="form-label">Size</label>
                       <input type="text" name="size" id="size" class="form-control" value="{{ old('size', $inventory->size) }}">
                       @error('size')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="weight" class="form-label">Weight (kg)</label>
                       <input type="number" name="weight" id="weight" class="form-control" step="0.01" value="{{ old('weight', $inventory->weight) }}" min="0">
                       @error('weight')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="expiryDate" class="form-label">Expiry Date</label>
                       <input type="date" name="expiryDate" id="expiryDate" class="form-control" value="{{ old('expiryDate', $inventory->expiryDate) }}">
                       @error('expiryDate')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="batchNumber" class="form-label">Batch Number</label>
                       <input type="text" name="batchNumber" id="batchNumber" class="form-control" value="{{ old('batchNumber', $inventory->batchNumber) }}">
                       @error('batchNumber')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="lastUpdate" class="form-label">Last Update</label>
                       <input type="date" name="lastUpdate" id="lastUpdate" class="form-control" value="{{ old('lastUpdate', $inventory->lastUpdate) }}">
                       @error('lastUpdate')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="shelfLocation" class="form-label">Shelf Location</label>
                       <input type="text" name="shelfLocation" id="shelfLocation" class="form-control" value="{{ old('shelfLocation', $inventory->shelfLocation) }}">
                       @error('shelfLocation')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
                   <div class="mb-4 col-md-6">
                       <label for="imageUrl" class="form-label">Image (Leave blank to keep current)</label>
                       <input type="file" name="imageUrl" id="imageUrl" class="form-control">
                       @if ($inventory->imageUrl)
                           <img src="{{ asset($inventory->imageUrl) }}" alt="Inventory Image" style="max-width: 100px; margin-top: 10px;">
                       @endif
                       @error('imageUrl')
                       <small class="text-danger">{{ $message }}</small>
                       @enderror
                   </div>
               </div>
                    <button type="submit" class="btn btn-primary">Update Inventory Item</button>
                    <a href="{{ route('admin.inventories.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
