# تعليمات النشر على السيرفر

## أوامر ضرورية بعد رفع الملفات

بعد رفع الملفات المعدلة على السيرفر، شغّل الأوامر التالية من جذر المشروع `learning-platform/`:

```bash
# 1. تنظيف كاش الروت (مهم جداً)
php artisan route:clear

# 2. تنظيف كاش الإعدادات
php artisan config:clear

# 3. تنظيف كاش التطبيق
php artisan cache:clear

# 4. تنظيف كاش الـ view
php artisan view:clear
```

## 1. مشكلة ملف المحاضرة 403 (تم التعديل)

### السبب
`Storage::url()` كانت تستخدم الـ default disk (`local`) بدل `public`. الـ `local` disk محفوظ في `storage/app/private` ومش متاح للعامة.

### الإصلاح
تم تغيير `Storage::url($lecture->file_url)` إلى `Storage::disk('public')->url($lecture->file_url)` في ملف عرض المحاضرة.

### ضروري على السيرفر
تأكد إنه symbolic link موجود بين `public/storage` و `storage/app/public`:

```bash
php artisan storage:link
```

لو الرابط موجود مسبقاً، احذفه الأول:
```bash
# حذف الرابط القديم (لو موجود)
rm -f public/storage

# إنشاء الرابط من جديد
php artisan storage:link
```

تحقق إنه الرابط شغال:
```bash
ls -la public/storage
```
يجب يشير إلى `../storage/app/public`

## 2. تسجيل الخروج (تم التعديل)

### السبب
كانت المشكلة مع session management مع database session driver.

### الإصلاح
تم تحسين `AuthController::logout()` ليحتفظ بالجلسة بشكل أدق:
- `Auth::guard('web')->logout()` - تسجيل خروج صريح
- `$request->session()->flush()` - مسح كل بيانات الجلسة
- `$request->session()->invalidate()` - تدمير الجلسة القديمة
- `$request->session()->regenerateToken()` - تجديد CSRF token
- `redirect('/login')` - توجيه مباشر لصفحة الدخول

## 3. توليد اختبار لمحاضرة عندها اختبار مسبقاً (تم التعديل)

### السبب
كانت تستخدم `abort_if()` اللي تعرض صفحة خطأ Laravel الكبيرة بدل إشعار بسيط.

### الإصلاح
تم تحويلها إلى `return back()->with('error', '...')` عشان تظهر إشعار (toast) في أعلى الصفحة.

## 4. تعديل الملف الشخصي - التوجيه للوحة التحكم (تم التعديل)

### السبب
كانت `return back()` ترجع المستخدم لنفس صفحة الملف الشخصي.

### الإصلاح
تم تغييرها إلى `redirect()->route(auth()->user()->role . '.dashboard')` عشان ترجع الطالب للوحة التحكم الخاصة فيه، أو الأستاذ للوحة تحكمه.

## تحقق من ملف .env

تأكد إن الإعدادات التالية صحيحة على السيرفر:

```env
FILESYSTEM_DISK=local
SESSION_DRIVER=database
APP_URL=https://your-domain.com
```

> **ملاحظة**: `FILESYSTEM_DISK=local` هو الصحيح كـ default. الملفات تتنرفع على `public` disk بشكل explicit من الكود.
