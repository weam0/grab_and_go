@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Add New Offer</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
                <li class="active"><a href="#">Create</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('admin.offers.store') }}" method="POST">
                    @csrf
                 <div class="row">
                     <div class="mb-4 col-md-6">
                         <label for="inventoryId" class="form-label">Inventory Item *</label>
                         <select name="inventoryId" id="inventoryId" class="form-control" required>
                             <option value="">Select an inventory item</option>
                             @foreach ($inventories as $inventory)
                                 <option value="{{ $inventory->inventoryId }}" {{ old('inventoryId') == $inventory->inventoryId ? 'selected' : '' }}>
                                     {{ $inventory->product->name }} ({{ $inventory->barcode }})
                                 </option>
                             @endforeach
                         </select>
                         @error('inventoryId')
                         <small class="text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="mb-4 col-md-6">
                         <label for="startDate" class="form-label">Start Date *</label>
                         <input type="date" name="startDate" id="startDate" class="form-control" value="{{ old('startDate') }}" required>
                         @error('startDate')
                         <small class="text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="mb-4 col-md-6">
                         <label for="endDate" class="form-label">End Date *</label>
                         <input type="date" name="endDate" id="endDate" class="form-control" value="{{ old('endDate') }}" required>
                         @error('endDate')
                         <small class="text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                     <div class="mb-4 col-md-6">
                         <label for="discountPercentage" class="form-label">Discount Percentage (%) *</label>
                         <input type="number" name="discountPercentage" id="discountPercentage" class="form-control" value="{{ old('discountPercentage') }}" min="0" max="100" step="0.01" required>
                         @error('discountPercentage')
                         <small class="text-danger">{{ $message }}</small>
                         @enderror
                     </div>
                 </div>
                    <button type="submit" class="btn btn-primary">Save Offer</button>
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
