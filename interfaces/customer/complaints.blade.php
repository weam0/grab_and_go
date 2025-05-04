@extends('layouts.customer')

@section('title', 'My Complaints')

@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">My Complaints</h1>
    </div>
    <div class="container">
        <div class="row">
            <ul class="breadcrumb wizard">
                <li class="completed"><a href="{{ route('customer.profile') }}">My Profile</a></li>
                <li class="active"><a href="#">My Complaints</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid py-2">
        <div class="container">
            @if ($complaints->isEmpty())
                <p class="text-center">You have no complaints yet.</p>
            @else
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Complaint History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th>Complaint ID</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Replied</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td>#{{ $complaint->complaintId }}</td>
                                        <td>#{{ $complaint->orderId }}</td>
                                        <td>{{ date('Y-m-d H:i A', strtotime($complaint->complaintDate)) }}</td>
                                        <td>{{ Str::limit($complaint->description, 50) }}</td>
                                        <td>{{ $complaint->status }}</td>
                                        <td>{{ $complaint->reply ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @if ($complaint->reply)
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#replyModal{{ $complaint->complaintId }}">
                                                    View Reply
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Reply Modal -->
                                    @if ($complaint->reply)
                                        <div class="modal fade" id="replyModal{{ $complaint->complaintId }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $complaint->complaintId }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="replyModalLabel{{ $complaint->complaintId }}">Reply to Complaint #{{ $complaint->complaintId }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Order ID:</strong> #{{ $complaint->orderId }}</p>
                                                        <p><strong>Your Complaint:</strong> {{ $complaint->description }}</p>
                                                        <hr>
                                                        <p><strong>Reply:</strong> {{ $complaint->reply }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
