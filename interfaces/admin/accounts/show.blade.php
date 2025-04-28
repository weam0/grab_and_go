@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">User Details</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.accounts.index') }}">Users</a></li>
                <li class="active"><a href="#">Details</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <h4>{{ $account->fullName }}</h4>
                <p><strong>ID:</strong> {{ $account->accountId }}</p>
                <p><strong>Email:</strong> {{ $account->email }}</p>
                <p><strong>Phone Number:</strong> {{ $account->phoneNumber }}</p>
                <p><strong>Account Type:</strong> {{ $account->accountType }}</p>
                <p><strong>Reward Points:</strong> {{ $account->rewardPoints }}</p>
                <p><strong>Locker Number:</strong> {{ $account->lockerNumber ?? 'N/A' }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.accounts.edit', $account) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
@endsection
