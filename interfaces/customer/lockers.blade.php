@extends('layouts.customer')

@section('title', 'My Lockers')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">My Lockers</h1>
    </div>

    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('customer.profile') }}">My Profile</a></li>
                <li class="active"><a href="#">My Lockers</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container">
            @if ($reservations->isEmpty())
                <p class="text-center">You have no locker reservations yet.</p>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Locker Reservation History</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($reservations as $res)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm border border-secondary">
                                        <div class="card-body">
                                            <h5 class="card-title mb-3">
                                                <i class="fa fa-lock me-1 text-primary"></i>
                                                Locker: {{ $res->locker->lockerNumber }}
                                            </h5>
                                            <p class="mb-1"><i class="fa fa-map-marker-alt text-danger"></i> {{ $res->locker->location }}</p>
                                            <p class="mb-1"><i class="fa fa-cube text-secondary"></i> Size: {{ $res->locker->size }}</p>
                                            <p class="mb-1"><i class="fa fa-calendar text-success"></i> From: {{ \Carbon\Carbon::parse($res->reservationStart)->format('M d, Y H:i') }}</p>
                                            <p class="mb-1"><i class="fa fa-clock text-warning"></i> To: {{ \Carbon\Carbon::parse($res->reservationEnd)->format('M d, Y H:i') }}</p>
                                            <p class="mb-0">
                                                <i class="fa fa-info-circle text-info"></i>
                                                Status:
                                                <span class="badge
                                                    {{ $res->status === 'active' ? 'bg-success' : ($res->status === 'expired' ? 'bg-danger' : 'bg-secondary') }}">
                                                    {{ ucfirst($res->status) }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
