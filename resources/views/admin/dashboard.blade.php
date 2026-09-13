@extends('layouts.admin')

@section('title', 'لوحة التحكم | جسر الأمل')
@section('page_title', 'لوحة التحكم الرئيسية')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(39, 174, 96, 0.1); color: #27AE60;">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">إجمالي الطلبات</span>
            <span class="stat-card__value">{{ $stats['total_orders'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(243, 156, 18, 0.1); color: #f39c12;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">طلبات قيد المراجعة</span>
            <span class="stat-card__value">{{ $stats['pending_orders'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
            <i class="fas fa-spinner"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">طلبات جاري العمل عليها</span>
            <span class="stat-card__value">{{ $stats['in_progress_orders'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(39, 174, 96, 0.1); color: #27AE60;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">طلبات مكتملة</span>
            <span class="stat-card__value">{{ $stats['completed_orders'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(155, 89, 182, 0.1); color: #9b59b6;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">إجمالي المستخدمين</span>
            <span class="stat-card__value">{{ $stats['total_users'] }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card__icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <div class="stat-card__info">
            <span class="stat-card__label">إجمالي الإيرادات</span>
            <span class="stat-card__value">{{ number_format($stats['total_revenue'], 0) }} ريال</span>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="admin-table-card" style="margin-top: 30px;">
    <div class="admin-table-header">
        <h3 class="admin-table-title">أحدث الطلبات</h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn--primary" style="padding: 6px 16px; font-size: 0.9rem;">عرض الكل</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
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
                @forelse($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->order_number }}</strong></td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->service->title }}</td>
                        <td>{{ $order->specialist ? $order->specialist->name : 'غير محدد' }}</td>
                        <td>{{ number_format($order->total_amount, 0) }} ريال</td>
                        <td><span class="status-badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span></td>
                        <td>{{ $order->payment_status->label() }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn--primary" style="padding: 4px 10px; font-size: 0.8rem;">إدارة</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #888; padding: 30px;">لا توجد طلبات حديثة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
