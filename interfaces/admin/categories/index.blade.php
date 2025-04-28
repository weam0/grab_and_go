@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Manage Categories</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Categories</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-row-reverse">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary text-center text-white">
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
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->categoryId }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No categories found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
