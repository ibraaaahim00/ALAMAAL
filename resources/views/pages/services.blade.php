@extends('layouts.app')

@section('title', 'جسر الأمل | الخدمات')

@section('content')
    <!-- ============================================
         PAGE HEADER / BREADCRUMB
    ============================================= -->
    <section class="page-header page-header--contact" id="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <span>الخدمات</span>
            </div>
        </div>
    </section>

    <!-- ============================================
         SERVICES SECTION
    ============================================= -->
    <section class="services page" id="services">
        <div class="container">
            <!-- Section Header -->
            <div class="services__header">
                <div class="services__header-text">
                    <span class="section-label">ماذا نقدم</span>
                    <h2 class="section-title section-title--red">خدماتنا الثلاث الأساسية التي نوفرها</h2>
                </div>
            </div>

            <!-- Service Cards -->
            <div class="services__grid">
                @foreach ($services as $service)
                    <div class="service-card">
                        <div class="service-card__image">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                        </div>
                        <h3 class="service-card__title">{{ $service->title }}</h3>
                        <p class="service-card__description">{{ $service->description }}</p>
                        <div class="service-card__footer">
                            <a href="{{ route('checkout', ['service' => $service->slug]) }}" class="btn btn--outline">
                                {{ $service->type->value === 'consultation' ? 'حجز استشارة' : 'طلب الخدمة' }}
                            </a>
                            <span class="service-card__price">{{ number_format($service->price, 0) }} ريال</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Trust Cards Section -->
    @include('partials.trust-cards')

    <!-- Newsletter Section -->
    @include('partials.newsletter')
@endsection
