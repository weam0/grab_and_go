@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Edit Category</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="form-label">Name *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
