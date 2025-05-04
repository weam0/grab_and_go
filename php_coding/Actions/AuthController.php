<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'accountType' => ['required', 'in:Admin,Customer,Employee'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::user();
            if ($user->accountType !== $request->accountType) {
                Auth::logout();
                return back()->withErrors(['accountType' => 'Selected account type does not match your account.']);
            }
            $request->session()->regenerate();
            if ($user->accountType == 'Admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
            }
            if ($user->accountType == 'Customer') {
                return redirect()->route('customer.profile')->with('success', 'Logged in successfully!');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email', 'accountType');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:account'],
            'phoneNumber' => ['required', 'regex:/^05\d{8}$/', 'unique:account'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', 'confirmed'],
        ], [
            'phoneNumber.regex' => 'Phone number must start with 05 followed by 8 digits.',
            'password.regex' => 'Password must be at least 8 characters, including an uppercase letter, lowercase letter, number, and special character.',
        ]);

        $account = Account::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => Hash::make($request->password),
            'accountType' => 'Customer',
            'rewardPoints' => 0,
        ]);

        Auth::login($account);

        return redirect()->route('home')->with('success', 'Registration successful! Welcome aboard!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
