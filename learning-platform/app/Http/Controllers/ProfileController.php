<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // ── Show Profile ─────────────────────────────
    public function show()
    {
        $user    = Auth::user();
        $profile = $user->getProfile();

        return view('profile.show', compact('user', 'profile'));
    }

    // ── Update Profile ───────────────────────────
    public function update(Request $request)
    {
        $user    = Auth::user();
        $profile = $user->getProfile();

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

    // ── Change Password ──────────────────────────
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        abort_if(
            !Hash::check($request->current_password, $user->password),
            422, 'كلمة المرور الحالية غير صحيحة.'
        );

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح ✓');
    }
}
