@extends('layouts.admin')

@section('title', 'إدارة الخدمات | لوحة التحكم')
@section('page_title', 'إدارة الخدمات')

@section('content')
<div class="admin-table-card">
    <div class="admin-table-header">
        <h3 class="admin-table-title">قائمة الخدمات</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn--primary" style="padding: 8px 18px;">+ إضافة خدمة جديدة</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>العنوان</th>
                    <th>النوع</th>
                    <th>السعر</th>
                    <th>الحالة</th>
                    <th>الترتيب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td><strong>{{ $service->title }}</strong></td>
                        <td>{{ $service->type->label() }}</td>
                        <td>{{ number_format($service->price, 0) }} ريال</td>
                        <td>
                            @if($service->is_active)
                                <span class="status-badge status-badge--completed">مفعل</span>
                            @else
                                <span class="status-badge status-badge--cancelled">معطل</span>
                            @endif
                        </td>
                        <td>{{ $service->sort_order }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn--primary" style="padding: 4px 10px; font-size: 0.8rem;">تعديل</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--gray" style="padding: 4px 10px; font-size: 0.8rem; background: #dc3545; color: #fff;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 30px;">لا توجد خدمات مضافة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
