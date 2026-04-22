@extends('layouts.student')

@section('title', 'تصفح المواد - Smart Learn')

@section('page-content')
    <div class="mb-10 text-right">
        <h2 class="text-3xl font-extrabold text-white mb-2 font-plus-jakarta tracking-tight">تصفح المواد الدراسية</h2>
        <p class="text-on-surface-variant text-sm">اكتشف المواد المتاحة وسجّل فيها للبدء بالتعلم.</p>
    </div>

    <form method="GET" action="{{ route('student.courses.index') }}" class="mb-8">
        <div class="relative w-full">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث عن مادة..." class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-6 py-3 text-sm text-on-surface placeholder:text-on-surface-variant/50 focus:ring-1 focus:ring-primary focus:border-primary transition-all text-right" dir="rtl"/>
            <button type="submit" class="absolute left-4 top-3">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @forelse ($courses as $course)
            <div class="bg-surface-container rounded-2xl overflow-hidden group border border-transparent hover:border-indigo-500/20 transition-all duration-500">
                <div class="h-40 relative">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                         src="{{ $course->img_url ?? 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $course->title }}"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container to-transparent opacity-80"></div>
                </div>
                <div class="p-6 text-right">
                    <h4 class="text-lg font-bold text-white leading-tight mb-3">{{ $course->title }}</h4>
                    <p class="text-on-surface-variant text-xs mb-4 line-clamp-2">{{ $course->description }}</p>

                    <div class="flex flex-row-reverse gap-4 mb-6">
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">play_circle</span>
                            <span class="text-xs font-medium">{{ $course->lectures_count }} محاضرة</span>
                        </div>
                        <div class="flex items-center gap-1 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="text-xs font-medium">{{ $course->students_count }} طالب</span>
                        </div>
                    </div>

                    @if (in_array($course->id, $enrolledIds))
                        <div class="flex gap-2">
                            <a href="{{ route('student.courses.show', $course) }}" class="flex-1 text-center bg-primary/10 text-primary font-bold py-3 rounded-xl hover:bg-primary/20 transition-all text-sm">
                                عرض المادة
                            </a>
                            <form method="POST" action="{{ route('student.courses.drop', $course) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-error/10 text-error font-bold py-3 rounded-xl hover:bg-error/20 transition-all text-sm"
                                        onclick="return confirm('هل أنت متأكد من إلغاء التسجيل؟')">
                                    إلغاء التسجيل
                                </button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('student.courses.enroll', $course) }}">
                            @csrf
                            <button type="submit" class="w-full bg-primary text-on-primary font-bold py-3 rounded-xl hover:opacity-90 transition-all text-sm">
                                تسجيل في المادة
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-surface-container p-8 rounded-2xl text-center border border-dashed border-outline-variant/30">
                <span class="material-symbols-outlined text-6xl text-slate-600 mb-4">search_off</span>
                <h3 class="text-xl font-bold text-white mb-2">لا توجد نتائج</h3>
                <p class="text-on-surface-variant">لم يتم العثور على مواد تطابق بحثك.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $courses->withQueryString()->links() }}
    </div>
@endsection