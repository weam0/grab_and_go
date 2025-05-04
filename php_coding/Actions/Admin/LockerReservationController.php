<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LockerReservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LockerReservationController extends Controller
{
    public function index()
    {
        $reservations = LockerReservation::with('locker', 'account')->get();
        return view('admin.locker_reservations.index', compact('reservations'));
    }

    public function update(Request $request, $id)
    {

        $reservation = LockerReservation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }

}
