<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return view('admin.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:account,email'],
            'phoneNumber' => ['required', 'regex:/^05\d{8}$/', 'unique:account,phoneNumber'],
//            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', 'confirmed'],
            'accountType' => ['required', 'in:Admin,Customer,Employee'],
            'rewardPoints' => ['nullable', 'integer', 'min:0'],
            'lockerNumber' => ['nullable', 'string', 'max:255'],
        ], [
            'phoneNumber.regex' => 'Phone number must start with 05 followed by 8 digits.',
            'password.regex' => 'Password must be at least 12 characters, including an uppercase letter, lowercase letter, number, and special character.',
        ]);

        Account::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => Hash::make($request->password),
            'accountType' => $request->accountType,
            'rewardPoints' => $request->rewardPoints ?? 0,
            'lockerNumber' => $request->lockerNumber,
        ]);

        return redirect()->route('admin.accounts.index')->with('success', 'Account created successfully!');
    }

    public function show(Account $account)
    {
        return view('admin.accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        return view('admin.accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:account,email,' . $account->accountId . ',accountId'],
            'phoneNumber' => ['required', 'regex:/^05\d{8}$/', 'unique:account,phoneNumber,' . $account->accountId . ',accountId'],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', 'confirmed'],
            'accountType' => ['required', 'in:Admin,Customer,Employee'],
            'rewardPoints' => ['nullable', 'integer', 'min:0'],
            'lockerNumber' => ['nullable', 'string', 'max:255'],
        ], [
            'phoneNumber.regex' => 'Phone number must start with 05 followed by 8 digits.',
            'password.regex' => 'Password must be at least 12 characters, including an uppercase letter, lowercase letter, number, and special character.',
        ]);

        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'accountType' => $request->accountType,
            'rewardPoints' => $request->rewardPoints ?? 0,
            'lockerNumber' => $request->lockerNumber,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $account->update($data);

        return redirect()->route('admin.accounts.index')->with('success', 'Account updated successfully!');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Account deleted successfully!');
    }
}
