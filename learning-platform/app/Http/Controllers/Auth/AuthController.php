<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\teachers;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Show Register Form ──────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── Register ────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'role'       => ['required', 'in:teacher,student'],
            'username'   => ['required', 'string', 'max:50', 'unique:users'],
            'password'   => ['required', 'confirmed', Password::min(8)],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'unique:teachers,email', 'unique:students,email'],
            'gender'     => ['required', 'in:male,female'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'location'   => ['nullable', 'string', 'max:100'],
            'major'      => ['nullable', 'required_if:role,student', 'string', 'max:100'],
        ]);

        // 1. إنشاء سجل في Users
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // 2. إنشاء الملف الشخصي حسب الدور
        $profileData = [
            'user_id'    => $user->id,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'gender'     => $request->gender,
            'phone'      => $request->phone,
            'location'   => $request->location,
        ];

        if ($request->role === 'teacher') {
            teachers::create($profileData);
        } else {
            students::create(array_merge($profileData, [
                'major' => $request->major,
            ]));
        }

        // 3. تسجيل الدخول تلقائياً
        Auth::login($user);

        return redirect()->route($request->role . '.dashboard');
    }

    // ── Show Login Form ─────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    // ── Login ────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('username', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()->withErrors([
                'username' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        $role = Auth::user()->role;

        return redirect()->intended(route($role . '.dashboard'));
    }

    // ── Logout ───────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
