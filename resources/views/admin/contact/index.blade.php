@extends('layouts.admin')

@section('title', 'رسائل التواصل | لوحة التحكم')
@section('page_title', 'رسائل تواصل معنا')

@section('content')
<div class="admin-table-card">
    <div class="admin-table-header">
        <h3 class="admin-table-title">رسائل الزوار ({{ $messages->total() }})</h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الجوال</th>
                    <th>البريد الإلكتروني</th>
                    <th>الرسالة</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr style="{{ !$msg->is_read ? 'background-color: rgba(39, 174, 96, 0.05); font-weight: 500;' : '' }}">
                        <td>{{ $msg->name }}</td>
                        <td>{{ $msg->phone }}</td>
                        <td>{{ $msg->email }}</td>
                        <td style="max-width: 300px;">{{ $msg->message }}</td>
                        <td>
                            @if($msg->is_read)
                                <span class="status-badge status-badge--completed">مقروءة</span>
                            @else
                                <span class="status-badge status-badge--pending">جديدة</span>
                            @endif
                        </td>
                        <td>{{ $msg->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                @if(!$msg->is_read)
                                    <form method="POST" action="{{ route('admin.contact.mark-read', $msg) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn--primary" style="padding: 4px 8px; font-size: 0.8rem;">تحديد كمقروء</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.contact.destroy', $msg) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--gray" style="padding: 4px 8px; font-size: 0.8rem; background: #dc3545; color: #fff;">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 30px;">لا توجد رسائل تواصل</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
        <div style="margin-top: 20px;">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
