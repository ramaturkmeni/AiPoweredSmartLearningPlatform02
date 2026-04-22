@extends('layouts.app')

@section('title', 'الملف الشخصي - Smart Learn')

@section('content')
    <div class="min-h-screen bg-background p-8" dir="rtl">
        <div class="max-w-4xl mx-auto">
            <div class="mb-10 text-right">
                <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">الملف الشخصي</h2>
                <p class="text-on-surface-variant text-sm">إدارة معلوماتك الشخصية وإعدادات الحساب.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-surface-container-low rounded-2xl p-8 text-center">
                    <div class="w-24 h-24 rounded-full border-4 border-primary/30 bg-indigo-900 flex items-center justify-center text-white text-3xl font-black mx-auto mb-6">
                        {{ mb_substr($profile->first_name, 0, 1) }}{{ mb_substr($profile->last_name, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">{{ $profile->first_name }} {{ $profile->last_name }}</h3>
                    <p class="text-on-surface-variant text-sm mb-4">{{ $profile->email }}</p>
                    <span class="inline-flex items-center gap-1 bg-primary/10 text-primary text-xs font-bold px-3 py-1 rounded-full">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ $user->isStudent() ? 'طالب' : 'أستاذ' }}
                    </span>
                    <div class="mt-6 space-y-3 text-right">
                        @if ($profile->phone)
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-base">phone</span>
                                {{ $profile->phone }}
                            </div>
                        @endif
                        @if ($profile->location)
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-base">location_on</span>
                                {{ $profile->location }}
                            </div>
                        @endif
                        @if ($user->isStudent() && $profile->major)
                            <div class="flex items-center gap-2 text-on-surface-variant text-sm">
                                <span class="material-symbols-outlined text-base">school</span>
                                {{ $profile->major }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-surface-container-low rounded-2xl p-8">
                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2 flex-row-reverse justify-end">
                            <span class="material-symbols-outlined text-primary">edit</span>
                            تعديل المعلومات
                        </h3>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @method('PUT')
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">الاسم الأول</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">الاسم الأخير</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">البريد الإلكتروني</label>
                                    <input type="email" name="email" value="{{ old('email', $profile->email) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">الجنس</label>
                                    <select name="gender" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required>
                                        <option value="male" {{ old('gender', $profile->gender) === 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender', $profile->gender) === 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">رقم الهاتف</label>
                                    <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right"/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">الموقع</label>
                                    <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right"/>
                                </div>
                                @if ($user->isStudent())
                                    <div class="md:col-span-2">
                                        <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">التخصص</label>
                                        <input type="text" name="major" value="{{ old('major', $profile->major) }}" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right"/>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="bg-primary text-on-primary font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    حفظ التغييرات
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-surface-container-low rounded-2xl p-8">
                        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2 flex-row-reverse justify-end">
                            <span class="material-symbols-outlined text-secondary">lock</span>
                            تغيير كلمة المرور
                        </h3>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @method('PUT')
                            @csrf
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">كلمة المرور الحالية</label>
                                    <input type="password" name="current_password" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">كلمة المرور الجديدة</label>
                                    <input type="password" name="password" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                                <div>
                                    <label class="block text-on-surface-variant text-xs font-medium mb-2 text-right">تأكيد كلمة المرور</label>
                                    <input type="password" name="password_confirmation" class="w-full bg-surface-container border border-outline-variant/30 rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" required/>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="bg-secondary-container text-on-secondary font-bold py-3 px-8 rounded-xl hover:opacity-90 transition-all flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">key</span>
                                    تحديث كلمة المرور
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex justify-start">
                        <form method="POST" action="{{ route('logout') }}" id="profile-logout-form" class="hidden">@csrf</form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('profile-logout-form').submit();" class="flex items-center gap-2 text-error hover:opacity-80 transition-colors">
                            <span class="material-symbols-outlined">logout</span>
                            <span class="font-medium text-sm">تسجيل الخروج</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection