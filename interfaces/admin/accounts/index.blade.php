@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Manage Accounts</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Accounts</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="row mb-4">
                <div class="col-12 d-flex flex-row-reverse">
                    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary">
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
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Account Type</th>
                            <th>Reward Points</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <td>{{ $account->accountId }}</td>
                                <td>{{ $account->fullName }}</td>
                                <td>{{ $account->email }}</td>
                                <td>{{ $account->phoneNumber }}</td>
                                <td>{{ $account->accountType }}</td>
                                <td>{{ $account->rewardPoints }}</td>
                                <td>
                                    <a href="{{ route('admin.accounts.show', $account) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('admin.accounts.edit', $account) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @if(auth()->id() != $account->accountId)
                                    <form action="{{ route('admin.accounts.destroy', $account) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                    @endif
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
