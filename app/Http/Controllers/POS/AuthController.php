<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Requests\POS\Auth\LoginRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $employee = Employee::where('employee_number', $validated['employee_number'])->first();

        if (!$employee || !Hash::check($validated['pin'], $employee->pin)) {
            return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
        }

        $token = $employee->createToken('pos-token')->plainTextToken;

        return response()->json(['message' => 'POS Token issued.', 'token' => $token, 'user' => EmployeeResource::make($employee)]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Tokens revoked.']);
    }
}
