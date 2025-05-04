@extends('layouts.app')

@section('title', 'Checkout')
@push('css')
    <style>
        .locker-option input[type="radio"] {
            position: absolute;
            left: 15px;
            top: 15px;
        }
        .locker-option:hover {
            background-color: #f0f8ff;
            border-color: #007bff;
        }

        .lock  {
            margin-left: 22px;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <div class="container-fluid py-2">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row g-4">
                <!-- Cart Summary -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($cartItems as $item)
                                        @php
                                            $inventory = $item['inventory'];
                                            $quantity = $item['quantity'];
                                            $price = $inventory->price;
                                            $hasOffer = $inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate);
                                        @endphp
                                        <tr>
                                            <td>{{ $inventory->product->name }}</td>
                                            <td>
                                                @if ($hasOffer)
                                                    <span class="text-success">SAR {{ number_format($price, 2) }}</span>
                                                    <small class="text-danger text-decoration-line-through">SAR {{ number_format($price / (1 - $inventory->offers->first()->discountPercentage / 100), 2) }}</small>
                                                @else
                                                    SAR {{ number_format($price, 2) }}
                                                @endif
                                            </td>
                                            <td>{{ $quantity }}</td>
                                            <td>
                                                @if ($hasOffer)
                                                    <span class="text-success">SAR {{ number_format($price * $quantity, 2) }}</span>
                                                    <small class="text-danger text-decoration-line-through">SAR {{ number_format(($price / (1 - $inventory->offers->first()->discountPercentage / 100)) * $quantity, 2) }}</small>
                                                @else
                                                    SAR {{ number_format($price * $quantity, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3 p-3 bg-light rounded">
                                <h5 class="fw-bold">Total:</h5>
                                <h5 class="fw-bold">SAR {{ number_format($total, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Form -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">Payment Details</h5>
                        </div>
                        <div class="card-body p-4">
                            <ul class="nav nav-pills rounded nav-fill mb-4 bg-light" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active py-2" data-bs-toggle="pill" href="#nav-tab-card">
                                        <i class="fa fa-credit-card me-2"></i>Credit Card
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2" data-bs-toggle="pill" href="#nav-tab-cash">
                                        <i class="fa fa-money-bill me-2"></i>Cash
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Credit Card Tab -->
                                <div class="tab-pane fade show active" id="nav-tab-card">
                                    <form action="{{ route('customer.checkout.store') }}" method="POST" role="form">
                                        @csrf
                                        <input type="hidden" name="paymentMethod" value="Credit Card">

                                        @if ($errors->any())
                                            <p class="alert alert-danger">
                                                {{ $errors->first() }}
                                            </p>
                                        @endif

                                        <div class="mb-3">
                                            <label for="username" class="form-label fw-semibold">Full Name (on the card)</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="" required>
                                            @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label fw-semibold">Card Number</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control @error('cardNumber') is-invalid @enderror" name="cardNumber" value="{{ old('cardNumber') }}" placeholder="1234 5678 9012 3456" maxlength="16" required>
                                                <span class="input-group-text text-muted">
                                                    <i class="fab fa-cc-visa"></i>
                                                    <i class="fab fa-cc-amex mx-1"></i>
                                                    <i class="fab fa-cc-mastercard"></i>
                                                </span>
                                            </div>
                                            @error('cardNumber')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-8">
                                                <label class="form-label fw-semibold">Expiration Date</label>
                                                <div class="input-group">
                                                    <select name="expiryMonth" id="expiryMonth" class="form-control @error('cardExpiryDate') is-invalid @enderror" required>
                                                        <option value="">Month</option>
                                                    </select>
                                                    <span class="input-group-text">/</span>
                                                    <select name="expiryYear" id="expiryYear" class="form-control @error('cardExpiryDate') is-invalid @enderror" required>
                                                        <option value="">Year</option>
                                                    </select>
                                                </div>
                                                @error('cardExpiryDate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="cvv" class="form-label fw-semibold">CVV <i class="fa fa-question-circle" data-bs-toggle="tooltip" title="3-digit code on the back of your card"></i></label>
                                                <input type="text" class="form-control @error('cvv') is-invalid @enderror" name="cvv" value="{{ old('cvv') }}" placeholder="123" maxlength="3" required>
                                                @error('cvv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <button class="btn btn-primary btn-block w-100 py-2" type="submit">Confirm Payment</button>
                                    </form>
                                </div>

                                <!-- Cash Tab -->
                                <div class="tab-pane fade" id="nav-tab-cash">
                                    <form action="{{ route('customer.checkout.store') }}" method="POST" role="form">
                                        @csrf
                                        <input type="hidden" name="paymentMethod" value="Cash">

                                        @if ($errors->any())
                                            <p class="alert alert-danger">
                                                {{ $errors->first() }}
                                            </p>
                                        @endif

                                        <p class="text-muted">Cash payment will be collected upon delivery.</p>
                                        <p class="text-muted"><strong>Note:</strong> Please have the exact amount of SAR {{ number_format($total, 2) }} ready when your order arrives.</p>
                                        <button class="btn btn-primary btn-block w-100 py-2" type="submit">Place Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 text-white">Select Locker for Pickup:</h5>
                        </div>
                        <div class="card-body p-4">
                            @error('lockerId')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="row">
                                @forelse($availableLockers as $locker)
                                    <div class="col-md-12">
                                        <label class="card shadow-sm border border-primary mb-3 p-3 w-100 locker-option" style="cursor: pointer;">
                                            <input type="radio" name="lockerId" value="{{ $locker->lockerId }}" class="form-check-input me-2" required>
                                            <h6 class="mb-2"><strong class="lock">{{ $locker->lockerNumber }}</strong></h6>
                                            <p class="mb-1"><i class="fa fa-map-marker-alt text-primary"></i> {{ $locker->location }}</p>
                                            <p class="mb-0"><i class="fa fa-cube text-secondary"></i> Size: {{ $locker->size }}</p>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted">No available lockers at the moment.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Populate Month and Year dropdowns
        document.addEventListener('DOMContentLoaded', function () {
            const monthSelect = document.getElementById('expiryMonth');
            const yearSelect = document.getElementById('expiryYear');
            const currentYear = new Date().getFullYear();

            // Months (01-12)
            for (let i = 1; i <= 12; i++) {
                const month = i < 10 ? `0${i}` : i;
                const option = document.createElement('option');
                option.value = month;
                option.textContent = month;
                monthSelect.appendChild(option);
            }

            // Years (current year to +10 years)
            for (let i = currentYear; i <= currentYear + 10; i++) {
                const option = document.createElement('option');
                option.value = i.toString().slice(-2); // Last 2 digits (e.g., 25 for 2025)
                option.textContent = i;
                yearSelect.appendChild(option);
            }

            // Combine month and year into cardExpiryDate on form submit
            const form = document.querySelector('#nav-tab-card form');
            form.addEventListener('submit', function (e) {
                const month = monthSelect.value;
                const year = yearSelect.value;
                if (month && year) {
                    const expiryDateInput = document.createElement('input');
                    expiryDateInput.type = 'hidden';
                    expiryDateInput.name = 'cardExpiryDate';
                    expiryDateInput.value = `${month}/${year}`;
                    form.appendChild(expiryDateInput);
                }
            });
        });

        const lockerRadios = document.querySelectorAll('input[name="lockerId"]');
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const selectedLocker = document.querySelector('input[name="lockerId"]:checked');
                if (selectedLocker) {
                    const lockerInput = document.createElement('input');
                    lockerInput.type = 'hidden';
                    lockerInput.name = 'lockerId';
                    lockerInput.value = selectedLocker.value;
                    form.appendChild(lockerInput);
                }
            });
        });

    </script>
@endpush
