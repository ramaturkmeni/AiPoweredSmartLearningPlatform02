<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

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

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

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
            Teacher::create($profileData);
        } else {
            Student::create(array_merge($profileData, [
                'major' => $request->major,
            ]));
        }

        Auth::login($user);

        return redirect()->route($request->role . '.dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function profile()
    {
        $user    = Auth::user();
        $profile = $user->getProfile();

        return view('profile.show', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user    = Auth::user();
        $profile = $user->getProfile();

        if ($request->filled('current_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'confirmed', Password::min(8)],
            ]);

            $user->update(['password' => Hash::make($request->password)]);

            return back()->with('success', 'تم تحديث كلمة المرور بنجاح ✓');
        }

        $rules = [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'unique:' . ($user->isTeacher() ? 'teachers' : 'students') . ',email,' . $profile->id],
            'gender'     => ['required', 'in:male,female'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'location'   => ['nullable', 'string', 'max:100'],
        ];

        if ($user->isStudent()) {
            $rules['major'] = ['nullable', 'string', 'max:100'];
        }

        $request->validate($rules);

        $data = $request->only('first_name', 'last_name', 'email', 'gender', 'phone', 'location');

        if ($user->isStudent()) {
            $data['major'] = $request->major;
        }

        $profile->update($data);

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح ✓');
    }
}