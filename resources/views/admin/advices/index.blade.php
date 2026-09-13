@extends('layouts.admin')

@section('title', 'إدارة نصائح الفيديو | لوحة التحكم')
@section('page_title', 'إدارة نصائح الفيديو')

@section('content')
<div class="admin-table-card">
    <div class="admin-table-header">
        <h3 class="admin-table-title">قائمة الفيديوهات والنصائح ({{ $advices->total() }})</h3>
        <a href="{{ route('admin.advices.create') }}" class="btn btn--primary" style="padding: 8px 18px;">+ إضافة فيديو / نصيحة</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الصورة / المعاينة</th>
                    <th>العنوان</th>
                    <th>السنة</th>
                    <th>الشهر</th>
                    <th>المشاهدات</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($advices as $advice)
                    <tr>
                        <td>
                            <img src="{{ $advice->thumbnail_url }}" alt="{{ $advice->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td><strong>{{ $advice->title }}</strong></td>
                        <td>{{ $advice->year }}</td>
                        <td>{{ $advice->month_name }}</td>
                        <td>{{ $advice->views_count }}</td>
                        <td>
                            @if($advice->is_active)
                                <span class="status-badge status-badge--completed">مفعل</span>
                            @else
                                <span class="status-badge status-badge--cancelled">معطل</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <form method="POST" action="{{ route('admin.advices.destroy', $advice) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه النصيحة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--gray" style="padding: 4px 10px; font-size: 0.8rem; background: #dc3545; color: #fff;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 30px;">لا توجد نصائح فيديو مضافة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($advices->hasPages())
        <div style="margin-top: 20px;">
            {{ $advices->links() }}
        </div>
    @endif
</div>
@endsection
