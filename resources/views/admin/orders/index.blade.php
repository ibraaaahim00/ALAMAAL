@extends('layouts.admin')

@section('title', 'إدارة الطلبات | لوحة التحكم')
@section('page_title', 'إدارة طلبات العملاء')

@section('content')
<!-- Filter bar -->
<div style="background: #fff; padding: 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
    <form method="GET" action="{{ route('admin.orders.index') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
        <div style="flex: 1; min-width: 200px;">
            <label style="display: block; font-size: 0.85rem; margin-bottom: 6px; color: #555;">بحث (رقم الطلب أو اسم العميل أو الجوال)</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث هنا..." class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
        </div>

        <div style="width: 180px;">
            <label style="display: block; font-size: 0.85rem; margin-bottom: 6px; color: #555;">حالة الطلب</label>
            <select name="status" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
                <option value="">جميع الحالات</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>جاري العمل</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتمل</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn--primary" style="height: 42px; padding: 0 20px;">فلترة</button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn--gray" style="height: 42px; padding: 0 16px; margin-inline-start: 5px;">إعادة تعيين</a>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-table-card">
    <div class="admin-table-header">
        <h3 class="admin-table-title">قائمة الطلبات ({{ $orders->total() }})</h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
                    <th>الجوال</th>
                    <th>الخدمة</th>
                    <th>الأخصائي</th>
                    <th>المبلغ</th>
                    <th>حالة الطلب</th>
                    <th>حالة الدفع</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->service->title }}</td>
                        <td>{{ $order->specialist ? $order->specialist->name : 'غير محدد' }}</td>
                        <td>{{ number_format($order->total_amount, 0) }} ريال</td>
                        <td><span class="status-badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                        <td>{{ $order->payment_status->label() }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn--primary" style="padding: 4px 12px; font-size: 0.85rem;">تفاصيل</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; color: #888; padding: 30px;">لا توجد طلبات مطابقة للبحث</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="margin-top: 20px;">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
