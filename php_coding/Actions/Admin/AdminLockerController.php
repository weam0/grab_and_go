<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Locker;
use Illuminate\Http\Request;

class AdminLockerController extends Controller
{
    public function index()
    {
        $lockers = Locker::all();
        return view('admin.lockers.index', compact('lockers'));
    }

    public function create()
    {
        return view('admin.lockers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lockerNumber' => 'required|string|unique:locker,lockerNumber',
            'location' => 'required|string',
            'size' => 'required|string',
            'status' => 'required',
        ]);

        Locker::create($request->only(['lockerNumber', 'location', 'size', 'status']));

        return redirect()->route('admin.lockers.index')->with('success', 'Locker created successfully!');
    }

    public function edit(Locker $locker)
    {
        return view('admin.lockers.edit', compact('locker'));
    }

    public function update(Request $request, Locker $locker)
    {
        $request->validate([
            'lockerNumber' => 'required|string|unique:locker,lockerNumber,' . $locker->lockerId . ',lockerId',
            'location' => 'required|string',
            'size' => 'required|string',
            'status' => 'required',
        ]);

        $locker->update($request->only(['lockerNumber', 'location', 'size', 'status']));

        return redirect()->route('admin.lockers.index')->with('success', 'Locker updated successfully!');
    }

    public function destroy(Locker $locker)
    {
        $locker->delete();
        return redirect()->route('admin.lockers.index')->with('success', 'Locker deleted successfully!');
    }

    public function show(Locker $locker)
    {
        return view('admin.lockers.show', compact('locker'));
    }
}
