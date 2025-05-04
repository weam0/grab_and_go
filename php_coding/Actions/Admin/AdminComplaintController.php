<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminComplaintController extends Controller
{
    public function complaints()
    {
        $complaints = Complaint::with('account')->latest('complaintDate')->get();
        return view('admin.complaints', compact('complaints'));
    }

    public function reply(Request $request, $complaintId)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update([
            'reply' => $request->reply,
            'status' => $complaint->status === 'Pending' ? 'In Progress' : $complaint->status, // Auto-update status if still Pending
        ]);

        return redirect()->route('admin.complaints')->with('success', 'Reply saved successfully!');
    }

    public function updateStatus(Request $request, $complaintId)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
        ]);

        $complaint = Complaint::findOrFail($complaintId);
        $complaint->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.complaints')->with('success', 'Status updated successfully!');
    }
}
