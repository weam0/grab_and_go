@extends('layouts.admin')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Edit User</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="completed"><a href="{{ route('admin.accounts.index') }}">Users</a></li>
                <li class="active"><a href="#">Edit</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container py-2">
            <div class="card shadow-sm border-0 p-4">
                <form action="{{ route('admin.accounts.update', $account) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="fullName" class="form-label">Full Name *</label>
                            <input type="text" name="fullName" id="fullName" class="form-control" value="{{ old('fullName', $account->fullName) }}" required>
                            @error('fullName')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $account->email) }}" required>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="phoneNumber" class="form-label">Phone Number *</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="{{ old('phoneNumber', $account->phoneNumber) }}" required>
                            @error('phoneNumber')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="accountType" class="form-label">Account Type *</label>
                            <select name="accountType" id="accountType" class="form-control" required>
                                <option value="Admin" {{ old('accountType', $account->accountType) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Customer" {{ old('accountType', $account->accountType) == 'Customer' ? 'selected' : '' }}>Customer</option>
                                <option value="Employee" {{ old('accountType', $account->accountType) == 'Employee' ? 'selected' : '' }}>Employee</option>
                            </select>
                            @error('accountType')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="rewardPoints" class="form-label">Reward Points</label>
                            <input type="number" name="rewardPoints" id="rewardPoints" class="form-control" value="{{ old('rewardPoints', $account->rewardPoints) }}" min="0">
                            @error('rewardPoints')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="lockerNumber" class="form-label">Locker Number</label>
                            <input type="text" name="lockerNumber" id="lockerNumber" class="form-control" value="{{ old('lockerNumber', $account->lockerNumber) }}">
                            @error('lockerNumber')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
