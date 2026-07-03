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
                            {{-- <form method="POST" action="{{ route('student.courses.drop', $course) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-error/10 text-error font-bold py-3 rounded-xl hover:bg-error/20 transition-all text-sm"
                                        onclick="return confirm('هل أنت متأكد من إلغاء التسجيل؟')">
                                    إلغاء التسجيل
                                </button>
                            </form> --}}
                            <form method="POST" action="{{ route('student.courses.drop', $course) }}" class="flex-1">
                            @csrf
                            <!-- قمنا بتغيير نوع الزر إلى button واستدعاء دالة جافا سكريبت المخصصة -->
                            <button type="button" onclick="confirmDrop(this)" class="w-full bg-error/10 text-error font-bold py-3 rounded-xl hover:bg-error/20 transition-all text-sm">
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



    <!-- نافذة التأكيد المنسدلة من الأعلى المخصصة للانسحاب -->
<div id="confirm-drop-modal" class="fixed inset-0 z-[100] hidden flex items-start justify-center pt-24 bg-black/60 backdrop-blur-sm transition-all duration-300">
    <div class="bg-surface-container-high border border-outline-variant/30 p-6 rounded-2xl max-w-sm w-full mx-4 shadow-2xl text-right animate-fade-in">
        <div class="flex items-center gap-3 flex-row-reverse mb-4">
            <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">warning</span>
            <h4 class="text-white font-bold text-lg">تأكيد إلغاء التسجيل</h4>
        </div>
        <p class="text-on-surface-variant text-sm mb-6 leading-relaxed">هل أنت متأكد من رغبتك في إلغاء تسجيلك في هذه المادة الدراسية؟</p>
        <div class="flex gap-3 justify-end flex-row-reverse">
            <button id="modal-submit-btn" class="bg-error text-white font-black px-5 py-2.5 rounded-xl text-sm hover:opacity-90 transition-all">نعم، إلغاء</button>
            <button type="button" onclick="closeDropModal()" class="bg-surface-container-low text-on-surface-variant border border-outline-variant/30 px-5 py-2.5 rounded-xl text-sm hover:bg-surface-variant transition-all">تراجع</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeDropForm = null;

    // فتح نافذة التأكيد وحفظ الفورم المطلوب حذفه
    function confirmDrop(button) {
        activeDropForm = button.closest('form');
        const modal = document.getElementById('confirm-drop-modal');
        modal.classList.remove('hidden');
    }

    // إغلاق نافذة التأكيد
    function closeDropModal() {
        const modal = document.getElementById('confirm-drop-modal');
        modal.classList.add('hidden');
        activeDropForm = null;
    }

    // تنفيذ الحذف الفعلي عند الضغط على "نعم، إلغاء"
    document.getElementById('modal-submit-btn').addEventListener('click', function() {
        if (activeDropForm) {
            activeDropForm.submit();
        }
    });
</script>
@endpush
