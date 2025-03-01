<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests\POS\Auth\LoginRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pos.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $employee = Employee::where('employee_number', $validated['employee_number'])->first();

        if (! $employee || ! Hash::check($validated['pin'], $employee->pin)) {
            return back()->withErrors(['employee_number' => 'The provided credentials do not match our records.'])->onlyInput('employee_number');
        }

        Auth::guard('employee')->login($employee);

        $request->session()->regenerate();

        return redirect()->intended(route('pos.home'));
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('pos.auth.show-login-form');
    }
}
