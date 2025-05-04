<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Grab And Go | Admin </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-grow text-primary" role="status"></div>
</div>
@include('layouts.header')
<div class="navabar__grub">
    <div style="margin-top: 116px;" class="sidebar__navbar active">
        <span></span>
        <div style="padding-bottom: 90px;" class="px-3 position-relative">
            <ul class="sidebar__list--menu mt-5">
                <!-- Dashboard -->
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-cogs mr-2" aria-hidden="true"></i> Dashboard</a></li>

                <!-- User Management -->
                <li><a href="{{ route('admin.accounts.index') }}" class="{{ request()->is('admin/accounts*') ? 'active' : '' }}"><i class="fa fa-users mr-2" aria-hidden="true"></i> Accounts</a></li>

                <!-- Product Management -->
                <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}"><i class="fa fa-cube mr-2" aria-hidden="true"></i> Categories</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}"><i class="fa fa-box mr-2" aria-hidden="true"></i> Products</a></li>
                <li><a href="{{ route('admin.inventories.index') }}" class="{{ request()->is('admin/inventories*') ? 'active' : '' }}"><i class="fa fa-warehouse mr-2" aria-hidden="true"></i> Inventory</a></li>
                <li><a href="{{ route('admin.stock-shelves.index') }}" class="{{ request()->is('admin/stock-shelves*') ? 'active' : '' }}"><i class="fas fa-warehouse mr-2"></i> Stock Shelves</a></li>
                <li><a href="{{ route('admin.offers.index') }}" class="{{ request()->is('admin/offers*') ? 'active' : '' }}"><i class="fa fa-gift mr-2" aria-hidden="true"></i> Offers</a></li>

                <!-- Locker Management -->
                <li><a href="{{ route('admin.lockers.index') }}" class="{{ request()->is('admin/lockers*') ? 'active' : '' }}"><i class="fa fa-lock mr-2" aria-hidden="true"></i> Lockers</a></li>
                <li><a href="{{ route('admin.locker-reservations.index') }}" class="{{ request()->is('admin/locker-reservations*') ? 'active' : '' }}"><i class="fa fa-lock mr-2"></i> Locker Reservations</a></li>

                <!-- Orders & Reports -->
                <li><a href="{{ route('admin.orders') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}"><i class="fa fa-shopping-cart mr-2" aria-hidden="true"></i> Orders</a></li>
                <li><a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}"><i class="fa fa-file mr-2" aria-hidden="true"></i> Reports</a></li>

                <!-- Complaints -->
                <li><a href="{{ route('admin.complaints') }}" class="{{ request()->routeIs('admin.complaints') ? 'active' : '' }}"><i class="fa fa-exclamation-circle mr-2" aria-hidden="true"></i> Complaints</a></li>
            </ul>

        </div>
    </div>
    <div class="sidebar__content">
        <nav class="navbar navbar-expand-md sidebar__side p-3">
{{--            <a class="navabar__menu position-relative d-inline-block" href="#">--}}
{{--                <i class="fa fa-bars" aria-hidden="true"></i>--}}
{{--            </a>--}}
        </nav>
        <section style="margin-top: 55px;" class="pt-0 px-3">
            @yield('content')
        </section>
    </div>
</div>
<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/lib/lightbox/js/lightbox.min.js') }}"></script>
<script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,  // Enable search
            paging: false,    // Disable pagination
            // ordering: false,  // Disable sorting
            info: false       // Disable info text
        });
    });
</script>
@stack('js')
</body>
</html>
