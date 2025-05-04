@extends('layouts.app')

@section('content')
    <!-- Single Page Header Start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Register</h1>
        <br>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-muted">Register</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Register Start -->
    <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class=" m-auto bg-light rounded">
                <div class="row g-4 justify-content-around">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Create Customer Account</h1>
                            <p class="mb-4">Join the Smart Shopping Cart community as a customer and enjoy a seamless shopping experience.</p>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <input type="text" name="fullName" class="w-100 form-control border-0 py-3" placeholder="Your Full Name *" value="{{ old('fullName') }}" required>
                                @error('fullName')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="email" name="email" class="w-100 form-control border-0 py-3" placeholder="Enter Your Email *" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="text" name="phoneNumber" class="w-100 form-control border-0 py-3" placeholder="Your Phone Number (05XXXXXXXX) *" value="{{ old('phoneNumber') }}" required>
                                @error('phoneNumber')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" name="password" class="w-100 form-control border-0 py-3" placeholder="Enter Your Password *" required>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" name="password_confirmation" class="w-100 form-control border-0 py-3" placeholder="Confirm Your Password *" required>
                                @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary" type="submit">Register</button>
                        </form>
                        <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}" class="text-primary">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register End -->
@endsection
