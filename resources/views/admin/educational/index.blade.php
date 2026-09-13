@extends('layouts.admin')

@section('title', 'المحتوى التوعوي | لوحة التحكم')
@section('page_title', 'إدارة المحتوى التوعوي')

@section('content')
<div class="admin-table-card">
    <div class="admin-table-header">
        <h3 class="admin-table-title">المقالات والمحتوى التوعوي ({{ $contents->total() }})</h3>
        <a href="{{ route('admin.educational.create') }}" class="btn btn--primary" style="padding: 8px 18px;">+ إضافة محتوى جديد</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>القسم</th>
                    <th>المشاهدات</th>
                    <th>الحالة</th>
                    <th>تاريخ النشر</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td><strong>{{ $item->title }}</strong></td>
                        <td>{{ $item->category ? $item->category->name : 'عام' }}</td>
                        <td>{{ $item->views_count }}</td>
                        <td>
                            @if($item->is_published)
                                <span class="status-badge status-badge--completed">منشور</span>
                            @else
                                <span class="status-badge status-badge--pending">مسودة</span>
                            @endif
                        </td>
                        <td>{{ $item->published_at ? $item->published_at->format('Y-m-d') : '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.educational.edit', $item) }}" class="btn btn--primary" style="padding: 4px 10px; font-size: 0.8rem;">تعديل</a>
                                <form method="POST" action="{{ route('admin.educational.destroy', $item) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المحتوى؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--gray" style="padding: 4px 10px; font-size: 0.8rem; background: #dc3545; color: #fff;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 30px;">لا يوجد محتوى توعوي مضاف</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contents->hasPages())
        <div style="margin-top: 20px;">
            {{ $contents->links() }}
        </div>
    @endif
</div>
@endsection
