@extends('layouts.app')

@section('title', 'جسر الأمل | الطلبات')
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - الطلبات')

@section('content')
<!-- ============================================
     BREADCRUMB SECTION
============================================= -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <span class="active">الطلبات</span>
        </div>
    </div>
</section>

<!-- ============================================
     ORDERS SECTION
============================================= -->
<section class="orders-section">
    <div class="container">
        @include('partials.alerts')

        <div class="orders-grid">
            @forelse($orders as $order)
                <div class="order-card">
                    <div class="order-card__header">
                        <h3 class="order-card__title">{{ $order->service->title }}</h3>
                        <span class="status-badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
                    </div>
                    <div class="order-card__details">
                        <div class="order-card__row">
                            <span class="order-card__label">رقم الطلب :</span>
                            <span class="order-card__value">#{{ $order->order_number }}</span>
                        </div>
                        <div class="order-card__row">
                            <span class="order-card__label">الأخصائي المعين :</span>
                            <span class="order-card__value">{{ $order->specialist ? $order->specialist->name : 'قيد التعيين' }}</span>
                        </div>
                        <div class="order-card__row">
                            <span class="order-card__label">المبلغ الإجمالي :</span>
                            <span class="order-card__value">{{ number_format($order->total_amount, 0) }} ريال</span>
                        </div>
                    </div>
                    @if($order->status->value === 'completed')
                        <a href="{{ route('orders.show', $order) }}" class="btn btn--active-plan">عرض تفاصيل الخطة</a>
                    @else
                        <a href="{{ route('orders.show', $order) }}" class="btn btn--gray">عرض تفاصيل الخطة</a>
                    @endif
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; background: #fff; border-radius: 16px;">
                    <i class="fas fa-clipboard-list" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                    <h3 style="font-size: 1.3rem; margin-bottom: 10px;">لا توجد طلبات حتى الآن</h3>
                    <p style="color: #777; margin-bottom: 20px;">يمكنك استكشاف خدماتنا وتقديم طلب استشارة أو تأهيل لطفلك</p>
                    <a href="{{ route('services.index') }}" class="btn btn--primary">استكشف الخدمات</a>
                </div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div style="margin-top: 30px;">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</section>

@include('partials.trust-cards', ['bgClass' => 'bg-light'])
@include('partials.newsletter', ['altClass' => 'newsletter--alt'])
@endsection
