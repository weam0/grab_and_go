@extends('layouts.app')
@push('css')
    <style>
        .account-type-option {
            border: 2px solid #81c408;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            text-align: center;
            width: 47%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .account-type-option input[type="radio"] {
            display: none;
        }

        .account-type-option.active {
            border-color: #ffffff;
            background-color: #81c408;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgb(98 255 0 / 25%);
        }

        .account-type-option label {
            cursor: pointer;
            font-weight: 600;
            margin-bottom: 0;
            display: block;
        }

        .account-type-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
    </style>
@endpush
@section('content')
    <!-- Single Page Header Start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Login</h1>
        <br>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-muted">Login</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Login Start -->
    <div class="container-fluid contact py-1">
        <div class="container py-5">
            <div class=" m-auto bg-light rounded">
                <div class="row g-4 justify-content-around">
                    <div class="col-12">
                        <div class="text-center mx-auto" style="max-width: 700px;">
                            <h1 class="text-primary">Sign In</h1>
                            <p class="mb-4">Log in to your Smart Shopping Cart account to start shopping smarter.</p>
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf


                            <div class="mb-4">
                                <label class="form-label">Select Account Type <span class="text-danger">*</span></label>
                                <div class="account-type-options">
                                    @foreach (['Customer', 'Admin'] as $type)
                                        <div class="account-type-option {{ old('accountType') == $type ? 'active' : '' }}" onclick="selectAccountType('{{ $type }}', this)">
                                            <input type="radio" name="accountType" value="{{ $type }}" id="accountType{{ $type }}" {{ old('accountType') == $type ? 'checked' : '' }} required>
                                            <label for="accountType{{ $type }}">{{ $type }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('accountType')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="mb-4">
                                <input type="email" name="email" class="w-100 form-control border-0 py-3" placeholder="Enter Your Email *" value="{{ old('email') }}" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" name="password" class="w-100 form-control border-0 py-3" placeholder="Enter Your Password *" required>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary" type="submit">Login</button>
                        </form>
                        <p class="mt-4 text-center">Don’t have an account? <a href="{{ route('register') }}" class="text-primary">Register here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->
@endsection
@push('js')

    <script>
        function selectAccountType(value, element) {
            document.querySelectorAll('.account-type-option').forEach(el => {
                el.classList.remove('active');
                el.querySelector('input[type=radio]').checked = false;
            });
            element.classList.add('active');
            element.querySelector('input[type=radio]').checked = true;
        }
    </script>
@endpush
