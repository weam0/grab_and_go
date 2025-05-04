<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Grab And Go | Customer </title>
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
<div class="navabar__grub ">
    <div class="sidebar__navbar active no-print">
        <span></span>
        <div class="px-3 py-4 position-relative">
            <ul class="sidebar__list--menu mt-5">
{{--                <li><a href="{{ route('customer.home') }}" class="{{ request()->routeIs('customer.home') ? 'active' : '' }}"><i class="fa fa-home mr-2" aria-hidden="true"></i> Home</a></li>--}}
                <li><a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}"><i class="fa fa-user mr-2" aria-hidden="true"></i> My Profile</a></li>
                <li><a href="{{ route('customer.password') }}" class="{{ request()->routeIs('customer.password') ? 'active' : '' }}"><i class="fa fa-lock mr-2" aria-hidden="true"></i> Change Password</a></li>
                <li><a href="{{ route('customer.orders') }}" class="{{ request()->routeIs('customer.orders') ? 'active' : '' }}"><i class="fa fa-shopping-bag mr-2" aria-hidden="true"></i> My Orders</a></li>
                <li><a href="{{ route('customer.complaints') }}" class="{{ request()->routeIs('customer.complaints') ? 'active' : '' }}"><i class="fa fa-exclamation-circle mr-2" aria-hidden="true"></i> My Complaints</a></li>

                <li>
                    <a href="{{ route('customer.lockers') }}" class="{{ request()->routeIs('customer.lockers') ? 'active' : '' }}">
                        <i class="fa fa-lock mr-2" aria-hidden="true"></i> My Lockers
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 {{ request()->routeIs('logout') ? 'active' : '' }}" style="color: inherit; text-decoration: none;">
                            <i class="fa fa-sign-out-alt mr-2" aria-hidden="true"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar__content">
        <nav class="navbar no-print navbar-expand-md sidebar__side p-3">
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
