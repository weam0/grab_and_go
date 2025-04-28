@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Manage Offers</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Offers</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-row-reverse">
                    <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add
                    </a>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Inventory Item</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Discount (%)</th>
                            <th>Status</th>

                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($offers as $offer)
                            <tr>
                                <td>{{ $offer->offerId }}</td>
                                <td>{{ $offer->inventory->product->name }} ({{ $offer->inventory->barcode }})</td>
                                <td>{{ $offer->startDate }}</td>
                                <td>{{ $offer->endDate }}</td>
                                <td>{{ $offer->discountPercentage }}%</td>
                                <td>
                                    @if (now()->lt($offer->startDate))
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif (now()->gte($offer->startDate) && now()->lte($offer->endDate))
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.offers.show', $offer) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('admin.offers.edit', $offer) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="d-inline">
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
