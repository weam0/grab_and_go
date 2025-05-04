{{--@extends('layouts.app')--}}

{{--@section('title', 'Smart Cart Simulation')--}}

{{--@section('content')--}}
{{--    <div class="container-fluid page-header py-5">--}}
{{--        <h1 class="text-center text-dark display-6">Smart Cart Simulation</h1>--}}
{{--    </div>--}}

{{--    <div class="container">--}}


{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success mt-3">{{ session('success') }}</div>--}}
{{--        @endif--}}
{{--        @if (session('error'))--}}
{{--            <div class="alert alert-danger mt-3">{{ session('error') }}</div>--}}
{{--        @endif--}}

{{--        <!-- Buttons for Scanner and Image Upload -->--}}
{{--        <div class="d-flex gap-3 mt-4 mb-4">--}}
{{--            <button class="btn btn-success" onclick="startScanner()">Start Barcode Scanner</button>--}}

{{--            <label class="btn btn-secondary mb-0">--}}
{{--                Upload Barcode Image--}}
{{--                <input type="file" id="barcodeImage" accept="image/*" style="display: none;" onchange="scanBarcodeFromImage(this)">--}}
{{--            </label>--}}
{{--        </div>--}}

{{--        <!-- Hidden Form to submit barcode -->--}}
{{--        <form id="barcodeForm" action="{{ route('customer.smart-cart.add-barcode') }}" method="POST" style="display: none;">--}}
{{--            @csrf--}}
{{--            <input type="hidden" name="barcode" id="barcodeInput">--}}
{{--        </form>--}}

{{--        <div class="row g-4">--}}
{{--            <!-- Left side: Camera Reader -->--}}
{{--            <div class="col-lg-4">--}}
{{--                <div id="reader" style="width: 100%; display: none;"></div>--}}
{{--            </div>--}}
{{--            @if (session('scannedProduct'))--}}
{{--                @php--}}
{{--                    $scanned = session('scannedProduct');--}}
{{--                @endphp--}}

{{--                <div class="card border-0  shadow-sm mb-4">--}}
{{--                    <div class="card-header bg-primary text-white d-flex justify-content-between">--}}
{{--                        <h5 class="mb-0">📦 Product Info - Just Scanned</h5>--}}
{{--                    </div>--}}
{{--                    <div class="card-body d-flex align-items-start">--}}
{{--                        <img src="{{ asset($scanned->imageUrl ?? 'assets/img/default-product.jpg') }}" class="img-thumbnail me-3" style="width: 120px;">--}}
{{--                        <div class="flex-grow-1">--}}
{{--                            <h5>{{ $scanned->product->name }}</h5>--}}
{{--                            <p>Price: <strong>SAR {{ number_format($scanned->price, 2) }}</strong></p>--}}

{{--                            @if ($scanned->stockShelves->count())--}}
{{--                                <h6 class="mt-3">📍 Shelf Locations:</h6>--}}
{{--                                <div class="row">--}}
{{--                                    @foreach ($scanned->stockShelves as $shelf)--}}
{{--                                        <div class="col-md-4">--}}
{{--                                            <div class="card border shadow-sm mb-2">--}}
{{--                                                <div class="card-body">--}}
{{--                                                    <div class="d-flex align-items-center">--}}
{{--                                                        <i class="fas fa-warehouse fa-lg text-primary me-2"></i>--}}
{{--                                                        <div>--}}
{{--                                                            <h6 class="mb-0">{{ $shelf->location }}</h6>--}}
{{--                                                            <small>{{ $shelf->quantity }} in stock</small>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @else--}}
{{--                                <p class="text-danger mt-2">No shelves available for this product.</p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            <!-- Right side: Cart Summary -->--}}
{{--            <div class="col-lg-12">--}}
{{--                <div class="card border-0 shadow-sm mb-4">--}}
{{--                    <div class="card-header bg-primary text-white d-flex justify-content-between">--}}

{{--                        <h5 class="mb-0">🛒 Smart Cart Summary</h5>--}}
{{--                        <small class="text-light">Scanned Items</small>--}}
{{--                    </div>--}}
{{--                    <div class="card-body p-4">--}}
{{--                        @php--}}
{{--                            $smartCart = session('cart', []);--}}
{{--                            $total = 0;--}}
{{--                        @endphp--}}

{{--                        @if (empty($smartCart))--}}
{{--                            <p class="text-center text-muted">Your smart cart is empty. Start scanning!</p>--}}
{{--                        @else--}}
{{--                            @foreach ($smartCart as $inventoryId => $quantity)--}}
{{--                                @php--}}
{{--                                    $item = \App\Models\Inventory::with('product')->find($inventoryId);--}}
{{--                                    $price = $item->price ?? 0;--}}
{{--                                    $hasOffer = $item && $item->offers->isNotEmpty() && now()->between($item->offers->first()->startDate, $item->offers->first()->endDate);--}}
{{--                                    $subtotal = $price * $quantity;--}}
{{--                                    $total += $subtotal;--}}
{{--                                @endphp--}}
{{--                                @if ($item)--}}
{{--                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">--}}
{{--                                        <div class="d-flex align-items-center">--}}
{{--                                            <img src="{{ asset($item->imageUrl ?? 'assets/img/default-product.jpg') }}" alt="{{ $item->product->name }}" width="50" height="50" class="rounded me-3">--}}
{{--                                            <div>--}}
{{--                                                <h6 class="mb-0">{{ $item->product->name }}</h6>--}}
{{--                                                <small class="text-muted">x{{ $quantity }}</small>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="text-end">--}}
{{--                                            <h6 class="mb-0">SAR {{ number_format($subtotal, 2) }}</h6>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}

{{--                            <div class="d-flex justify-content-between fw-bold mt-3">--}}
{{--                                <h5>Total:</h5>--}}
{{--                                <h5>SAR {{ number_format($total, 2) }}</h5>--}}
{{--                            </div>--}}

{{--                            <div class="text-end mt-4">--}}
{{--                                <a href="{{ route('customer.checkout') }}" class="btn btn-lg btn-success w-100">Proceed to Checkout</a>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

{{--@push('js')--}}
{{--    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>--}}
{{--    <script>--}}
{{--        function startScanner() {--}}
{{--            document.getElementById('reader').style.display = 'block';--}}
{{--            const html5QrCode = new Html5Qrcode("reader");--}}

{{--            const qrCodeSuccessCallback = (decodedText, decodedResult) => {--}}
{{--                console.log(`Barcode detected: ${decodedText}`);--}}
{{--                html5QrCode.stop();--}}
{{--                document.getElementById('reader').style.display = 'none';--}}

{{--                document.getElementById('barcodeInput').value = decodedText;--}}
{{--                document.getElementById('barcodeForm').submit();--}}
{{--            };--}}

{{--            const config = { fps: 10, qrbox: 250 };--}}
{{--            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);--}}
{{--        }--}}

{{--        function scanBarcodeFromImage(input) {--}}
{{--            if (input.files.length === 0) {--}}
{{--                alert('Please select an image.');--}}
{{--                return;--}}
{{--            }--}}

{{--            const html5QrCode = new Html5Qrcode("reader");--}}

{{--            html5QrCode.scanFile(input.files[0], true)--}}
{{--                .then(decodedText => {--}}
{{--                    console.log(`Barcode detected from image: ${decodedText}`);--}}
{{--                    document.getElementById('barcodeInput').value = decodedText;--}}
{{--                    document.getElementById('barcodeForm').submit();--}}
{{--                })--}}
{{--                .catch(err => {--}}
{{--                    console.error('Error scanning file.', err);--}}
{{--                    alert('Could not scan the barcode from the uploaded image.');--}}
{{--                });--}}
{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}

@extends('layouts.app')

@section('title', 'Smart Cart Simulation')
@push('css')
    <style>
        .gg {
            padding: 15px;
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center display-4 fw-bold">Smart Cart Simulation</h1>
        <p class="text-center lead">Scan products and manage your cart with ease</p>
    </div>

    <div class="container py-5">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Scanner and Upload Buttons -->
        <div class="d-flex flex-wrap gap-3 mb-5">
            <button class="btn btn-primary btn-lg px-4 py-2 fw-medium shadow-sm" onclick="startScanner()">
                <i class="fas fa-qrcode me-2"></i> Start Barcode Scanner
            </button>
            <label class="btn btn-outline-primary btn-lg px-4 py-2 fw-medium shadow-sm">
                <i class="fas fa-upload me-2"></i> Upload Barcode Image
                <input type="file" id="barcodeImage" accept="image/*" style="display: none;" onchange="scanBarcodeFromImage(this)">
            </label>
        </div>

        <!-- Hidden Barcode Form -->
        <form id="barcodeForm" action="{{ route('customer.smart-cart.add-barcode') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="barcode" id="barcodeInput">
        </form>

        <div class="row g-4">
            <!-- Left: Scanner and Scanned Product -->
            <div class="col-lg-4">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 fw-bold"><i class="fas fa-camera me-2"></i> Barcode Scanner</h5>
                        <div id="reader" class="rounded" style="width: 100%; display: none;"></div>
                    </div>
                </div>

                @if (session('scannedProduct'))
                    @php
                        $scanned = session('scannedProduct');
                    @endphp
                    <div class="card border-0 shadow mb-4 animate__animated animate__fadeIn">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 gg fw-medium"><i class="fas fa-box-open me-2"></i> Recently Scanned</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($scanned->imageUrl ?? 'assets/img/default-product.jpg') }}"
                                     class="img-thumbnail me-3 rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-2 fw-bold">{{ $scanned->product->name }}</h5>
                                    <p class="mb-1">Price: <strong>SAR {{ number_format($scanned->price, 2) }}</strong></p>
                                </div>
                            </div>

                            @if ($scanned->stockShelves->count())
                                <h6 class="mt-4 fw-medium"><i class="fas fa-warehouse me-2"></i> Shelf Locations</h6>
                                <div class="row g-2">
                                    @foreach ($scanned->stockShelves as $shelf)
                                        <div class="col-md-12">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body p-3">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                        <div>
                                                            <p class="mb-0 fw-medium">{{ $shelf->location }}</p>
                                                            <small class="text-muted">{{ $shelf->quantity }} in stock</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-danger mt-3">No shelves available for this product.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Cart Summary -->
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-medium gg"><i class="fas fa-shopping-cart me-2"></i> Smart Cart</h5>
                        <small class="text-gg gg">{{ count(session('cart', [])) }} Item(s)</small>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $smartCart = session('cart', []);
                            $total = 0;
                        @endphp

                        @if (empty($smartCart))
                            <div class="text-center py-5">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <p class="text-muted fs-5">Your smart cart is empty. Start scanning products!</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($smartCart as $inventoryId => $quantity)
                                        @php
                                            $item = \App\Models\Inventory::with('product')->find($inventoryId);
                                            $price = $item->price ?? 0;
                                            $subtotal = $price * $quantity;
                                            $total += $subtotal;
                                        @endphp
                                        @if ($item)
                                            <tr class="animate__animated animate__fadeIn">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset($item->imageUrl ?? 'assets/img/default-product.jpg') }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="rounded me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                        <span>{{ $item->product->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $quantity }}</td>
                                                <td>SAR {{ number_format($price, 2) }}</td>
                                                <td>SAR {{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded">
                                <h5 class="fw-bold mb-0">Total:</h5>
                                <h5 class="fw-bold mb-0">SAR {{ number_format($total, 2) }}</h5>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('customer.checkout') }}"
                                   class="btn btn-success btn-lg px-5 py-2 fw-medium shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i> Proceed to Checkout
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>

        .card {
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary, .btn-outline-primary {
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-primary:hover, .btn-outline-primary:hover {
            transform: scale(1.05);
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .btn-lg {
                padding: 0.5rem 1rem;
                font-size: 1rem;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    <script>
        function startScanner() {
            const reader = document.getElementById('reader');
            reader.style.display = 'block';
            reader.classList.add('animate__animated', 'animate__fadeIn');

            const html5QrCode = new Html5Qrcode("reader");

            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                console.log(`Barcode detected: ${decodedText}`);
                html5QrCode.stop();
                reader.style.display = 'none';
                reader.classList.remove('animate__animated', 'animate__fadeIn');

                document.getElementById('barcodeInput').value = decodedText;
                document.getElementById('barcodeForm').submit();
            };

            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
        }

        function scanBarcodeFromImage(input) {
            if (input.files.length === 0) {
                alert('Please select an image.');
                return;
            }

            const html5QrCode = new Html5Qrcode("reader");

            html5QrCode.scanFile(input.files[0], true)
                .then(decodedText => {
                    console.log(`Barcode detected from image: ${decodedText}`);
                    document.getElementById('barcodeInput').value = decodedText;
                    document.getElementById('barcodeForm').submit();
                })
                .catch(err => {
                    console.error('Error scanning file.', err);
                    alert('Could not scan the barcode from the uploaded image.');
                });
        }
    </script>
@endpush
