@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">My Profile</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('customer.profile') }}">My Profile</a></li>
                <li class="active"><a href="#">Update</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Update Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                    <div class="row">
                        <!-- Full Name -->
                        <div class="mb-3 col-md-6">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" name="fullName" id="fullName" class="form-control @error('fullName') is-invalid @enderror" value="{{ old('fullName', Auth::user()->fullName) }}" required>
                            @error('fullName')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3 col-md-6">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="text" name="phoneNumber" id="phoneNumber" class="form-control @error('phoneNumber') is-invalid @enderror" value="{{ old('phoneNumber', Auth::user()->phoneNumber ?? '') }}">
                            @error('phoneNumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Account Type (Optional, might be admin-only) -->
                        <div class="mb-3 col-md-6">
                            <label for="accountType" class="form-label">Account Type</label>
                            <select name="accountType" id="accountType" class="form-control @error('accountType') is-invalid @enderror" disabled>
                                <option value="customer" {{ Auth::user()->accountType === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="admin" {{ Auth::user()->accountType === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('accountType')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">This field is managed by administrators.</small>
                        </div>

                        <!-- Reward Points (Optional, might be read-only) -->
                        <div class="mb-3 col-md-6">
                            <label for="rewardPoints" class="form-label">Reward Points</label>
                            <input type="number" name="rewardPoints" id="rewardPoints" class="form-control @error('rewardPoints') is-invalid @enderror" value="{{ old('rewardPoints', Auth::user()->rewardPoints ?? 0) }}" disabled>
                            @error('rewardPoints')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Reward points are updated automatically.</small>
                        </div>

                        <!-- Locker Number (Optional) -->
                        <div class="mb-3 col-md-6">
                            <label for="lockerNumber" class="form-label">Locker Number</label>
                            <input type="text" name="lockerNumber" id="lockerNumber" class="form-control @error('lockerNumber') is-invalid @enderror" value="{{ old('lockerNumber', Auth::user()->lockerNumber ?? '') }}">
                            @error('lockerNumber')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
