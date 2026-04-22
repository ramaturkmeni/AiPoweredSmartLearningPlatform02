<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\teachers;
use App\Models\students;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // استخدام Faker باللغة العربية لتوليد أسماء حقيقية
        $faker = Faker::create('ar_SA');

        // ==========================================
        // 1. حسابات ثابتة للاختبار (لكي تدخل بها للموقع)
        // ==========================================

        // حساب الأستاذ الثابت
        $adminTeacher = User::create([
            'username' => 'doctor',
            'password' => Hash::make('password'), // كلمة المرور: password
            'role'     => 'teacher',
        ]);

        teachers::create([
            'user_id'    => $adminTeacher->id,
            'first_name' => 'أحمد',
            'last_name'  => 'خالد',
            'email'      => 'doctor@smartlearn.com',
            'gender'     => 'male',
            'phone'      => '0501234567',
            'location'   => 'الرياض',
        ]);

        // حساب الطالب الثابت
        $adminStudent = User::create([
            'username' => 'student',
            'password' => Hash::make('password'), // كلمة المرور: password
            'role'     => 'student',
        ]);

        students::create([
            'user_id'    => $adminStudent->id,
            'first_name' => 'علي',
            'last_name'  => 'محمد',
            'email'      => 'student@smartlearn.com',
            'gender'     => 'male',
            'phone'      => '0509876543',
            'location'   => 'جدة',
            'major'      => 'علوم الحاسب',

        ]);


        // ==========================================
        // 2. توليد أساتذة وهميين (5 أساتذة)
        // ==========================================
        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password'),
                'role'     => 'teacher',
            ]);

            teachers::create([
                'user_id'    => $user->id,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->unique()->safeEmail,
                'gender'     => $faker->randomElement(['male', 'female']),
                'phone'      => $faker->phoneNumber,
                'location'   => $faker->city,
            ]);
        }


        // ==========================================
        // 3. توليد طلاب وهميين (20 طالب)
        // ==========================================
        $majors = ['هندسة البرمجيات', 'الطب البشري', 'إدارة الأعمال', 'الذكاء الاصطناعي', 'القانون'];

        for ($i = 0; $i < 20; $i++) {
            $user = User::create([
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password'),
                'role'     => 'student',
            ]);

            students::create([
                'user_id'    => $user->id,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->unique()->safeEmail,
                'gender'     => $faker->randomElement(['male', 'female']),
                'phone'      => $faker->phoneNumber,
                'location'   => $faker->city,
                'major'      => $faker->randomElement($majors),
            ]);
        }

        $this->command->info('تم إنشاء الحسابات الوهمية بنجاح!');
        $this->command->info('------------------------------------');
        $this->command->info('حساب الأستاذ: username: doctor | pass: password');
        $this->command->info('حساب الطالب: username: student | pass: password');
    }
}
