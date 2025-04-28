@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Manage Products</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Products</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-row-reverse">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add
                    </a>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table id="dataTable" class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->productId }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td><img src="{{ asset($product->imageUrl) }}" alt="{{ $product->name }}" style="max-width: 50px;"></td>
                                <td>
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
