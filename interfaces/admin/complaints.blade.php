@extends('layouts.admin') <!-- Assuming an admin layout exists -->

@section('title', 'Complaints Management')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">Complaints</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="active"><a href="#">Complaints</a></li>
            </ul>
        </div>
    </div>


    <div class="container-fluid py-5">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($complaints->isEmpty())
                <p class="text-center">No complaints found.</p>
            @else
                <div class=>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Complaint ID</th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td>#{{ $complaint->complaintId }}</td>
                                        <td>#{{ $complaint->orderId }}</td>
                                        <td>{{ $complaint->account->fullName }}</td>
                                        <td>{{ date('Y-m-d H:i A', strtotime($complaint->complaintDate)) }}</td>
                                        <td>{{ Str::limit($complaint->description, 50) }}</td>
                                        <td>
                                            <form action="{{ route('admin.complaints.updateStatus', $complaint->complaintId) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                    <option value="Pending" {{ $complaint->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Resolved" {{ $complaint->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                                    <option value="Dismissed" {{ $complaint->status === 'Dismissed' ? 'selected' : '' }}>Dismissed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#replyModal{{ $complaint->complaintId }}">
                                                {{ $complaint->reply ? 'View/Edit Reply' : 'Reply' }}
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Reply Modal -->
                                    <div class="modal fade" id="replyModal{{ $complaint->complaintId }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $complaint->complaintId }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title text-white" id="replyModalLabel{{ $complaint->complaintId }}">Reply to Complaint #{{ $complaint->complaintId }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.complaints.reply', $complaint->complaintId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p><strong>Order ID:</strong> #{{ $complaint->orderId }}</p>
                                                        <p><strong>Customer:</strong> {{ $complaint->account->fullName }}</p>
                                                        <p><strong>Complaint:</strong> {{ $complaint->description }}</p>
                                                        <hr>
                                                        <div class="mb-3">
                                                            <label for="reply{{ $complaint->complaintId }}" class="form-label">Your Reply</label>
                                                            <textarea class="form-control @error('reply') is-invalid @enderror" id="reply{{ $complaint->complaintId }}" name="reply" rows="5" required>{{ old('reply', $complaint->reply) }}</textarea>
                                                            @error('reply')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Reply</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
