<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\CourseEnrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ar_SA');

        // ==========================================
        // 1. Fixed Test Accounts
        // ==========================================

        $adminTeacher = User::create([
            'username' => 'doctor',
            'password' => Hash::make('password'),
            'role'     => 'teacher',
        ]);

        Teacher::create([
            'user_id'    => $adminTeacher->id,
            'first_name' => 'أحمد',
            'last_name'  => 'خالد',
            'email'      => 'doctor@smartlearn.com',
            'gender'     => 'male',
            'phone'      => '0501234567',
            'location'   => 'الرياض',
        ]);

        $adminStudent = User::create([
            'username' => 'student',
            'password' => Hash::make('password'),
            'role'     => 'student',
        ]);

        Student::create([
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
        // 2. Random Teachers (5)
        // ==========================================

        $teacherIds = [$adminTeacher->teacher->id];

        for ($i = 0; $i < 5; $i++) {
            $user = User::create([
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password'),
                'role'     => 'teacher',
            ]);

            $teacher = Teacher::create([
                'user_id'    => $user->id,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->unique()->safeEmail,
                'gender'     => $faker->randomElement(['male', 'female']),
                'phone'      => $faker->phoneNumber,
                'location'   => $faker->city,
            ]);

            $teacherIds[] = $teacher->id;
        }

        // ==========================================
        // 3. Random Students (20)
        // ==========================================

        $majors = ['هندسة البرمجيات', 'الطب البشري', 'إدارة الأعمال', 'الذكاء الاصطناعي', 'القانون'];
        $studentIds = [$adminStudent->student->id];

        for ($i = 0; $i < 20; $i++) {
            $user = User::create([
                'username' => $faker->unique()->userName,
                'password' => Hash::make('password'),
                'role'     => 'student',
            ]);

            $student = Student::create([
                'user_id'    => $user->id,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->unique()->safeEmail,
                'gender'     => $faker->randomElement(['male', 'female']),
                'phone'      => $faker->phoneNumber,
                'location'   => $faker->city,
                'major'      => $faker->randomElement($majors),
            ]);

            $studentIds[] = $student->id;
        }

        // ==========================================
        // 4. Courses (3 per teacher)
        // ==========================================

        $courseTitles = [
            'هندسة البرمجيات', 'قواعد البيانات', 'الذكاء الاصطناعي',
            'أمن المعلومات', 'شبكات الحاسب', 'تطوير الويب',
            'الخوارزميات وهياكل البيانات', 'تعلم الآلة', 'البرمجة كائنية التوجه',
            'أنظمة التشغيل', 'الشبكات العصبية', 'معالجة اللغات الطبيعية',
            'الرؤية الحاسوبية', 'تحليل البيانات', 'الحوسبة السحابية',
            'هندسة المتطلبات', 'إدارة المشاريع', 'التجارة الإلكترونية',
        ];

        $courseIds = [];
        $courseIndex = 0;

        foreach ($teacherIds as $tid) {
            for ($j = 0; $j < 3; $j++) {
                $course = Course::create([
                    'teacher_id'  => $tid,
                    'title'       => $courseTitles[$courseIndex % count($courseTitles)],
                    'description' => $faker->paragraph(2),
                ]);
                $courseIds[] = $course->id;
                $courseIndex++;
            }
        }

        // ==========================================
        // 5. Lectures (2-4 per course)
        // ==========================================

        $lectureTitles = [
            'مقدمة في المادة', 'المفاهيم الأساسية', 'التطبيقات العملية',
            'المتقدمـات', 'مراجعة شاملة', 'دراسة حالة',
            'الأسس النظرية', 'ورشة عمل تطبيقية',
        ];

        $lectureIds = [];

        foreach ($courseIds as $cid) {
            $lecCount = rand(2, 4);
            for ($k = 0; $k < $lecCount; $k++) {
                $lecture = Lecture::create([
                    'course_id'    => $cid,
                    'title'        => $lectureTitles[$k % count($lectureTitles)],
                    'content_text' => $faker->paragraphs(3, true),
                    'order_index'  => $k,
                ]);
                $lectureIds[] = $lecture->id;
            }
        }

        // ==========================================
        // 6. Quizzes (1 per some lectures)
        // ==========================================

        $quizIds = [];

        foreach (array_slice($lectureIds, 0, 8) as $lid) {
            $quiz = Quiz::create([
                'lecture_id'      => $lid,
                'title'           => 'اختبار: ' . Lecture::find($lid)->title,
                'is_ai_generated' => true,
                'status'          => 'published',
            ]);
            $quizIds[] = $quiz->id;

            for ($q = 0; $q < 3; $q++) {
                $question = Question::create([
                    'quiz_id'       => $quiz->id,
                    'question_text' => $faker->sentence . '؟',
                ]);

                $correctIndex = rand(0, 3);
                $optionTexts = [$faker->word, $faker->word, $faker->word, $faker->word];

                for ($o = 0; $o < 4; $o++) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionTexts[$o],
                        'is_correct'  => $o === $correctIndex,
                    ]);
                }
            }
        }

        // ==========================================
        // 7. Enrollments (students in courses)
        // ==========================================

        foreach ($studentIds as $sid) {
            $randomCourses = array_rand(array_flip($courseIds), min(3, count($courseIds)));
            if (!is_array($randomCourses)) {
                $randomCourses = [$randomCourses];
            }
            foreach ($randomCourses as $cid) {
                CourseEnrollment::create([
                    'student_id'  => $sid,
                    'course_id'   => $cid,
                    'status'      => 'active',
                    'enrolled_at' => now(),
                ]);
            }
        }

        $this->command->info('تم إنشاء البيانات التجريبية بنجاح!');
        $this->command->info('------------------------------------');
        $this->command->info('حساب الأستاذ: username: doctor | pass: password');
        $this->command->info('حساب الطالب: username: student | pass: password');
    }
}