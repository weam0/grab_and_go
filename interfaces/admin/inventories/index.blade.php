@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Manage Inventory</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Inventory</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-row-reverse">

                <a href="{{ route('admin.inventories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add
                    </a>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table id="dataTable" class="table table-hover table-bordered text-center">
                        <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Barcode</th>
                            <th class="text-center">Quantity</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventories as $inventory)
                            <tr>
                                <td>{{ $inventory->inventoryId }}</td>
                                <td>{{ $inventory->product->name }}</td>
                                <td>
                                    <svg class="w-50" style="width: 110px !important;" id="barcode-{{ $inventory->inventoryId }}"></svg>
                                </td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>SAR {{ number_format($inventory->price, 2) }}</td>
                                <td>
                                    @if ($inventory->imageUrl)
                                        <img src="{{ asset($inventory->imageUrl) }}" alt="Inventory Image" style="max-width: 50px;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.inventories.show', $inventory) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.inventories.edit', $inventory) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.inventories.destroy', $inventory) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
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
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($inventories as $inventory)
            JsBarcode("#barcode-{{ $inventory->inventoryId }}", "{{ $inventory->barcode }}", {
                format: "CODE128",
                displayValue: true,
                lineColor: "#5d5454",
                width: 2,
                height: 40
            });
            @endforeach
        });
    </script>
@endpush
