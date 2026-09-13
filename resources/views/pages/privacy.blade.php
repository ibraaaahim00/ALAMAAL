@extends('layouts.app')

@section('title', 'جسر الأمل | سياسة الخصوصية')
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - سياسة الخصوصية')

@section('content')
<!-- ============================================
     PAGE HEADER SECTION
============================================= -->
<section class="page-header" id="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <span>سياسة الخصوصية</span>
        </div>
    </div>
</section>

<!-- ============================================
     PRIVACY POLICY CONTENT
============================================= -->
<section class="privacy-policy" id="privacy-policy">
    <div class="container">
        <div class="about__grid">
            <!-- Text Content -->
            <div class="about__content">
                <span class="section-label">حماية بياناتك</span>
                <h2 class="section-title section-title--red">سياسة الخصوصية و حماية المعلومات</h2>
                <div class="policy-text">
                    <p class="about__text">نحن في "جسر الأمل" نلتزم بحماية خصوصيتك وضمان أمان بياناتك الشخصية.
                        توضح هذه السياسة كيفية جمعنا واستخدامنا وحمايتنا للمعلومات التي تقدمها لنا.</p>

                    <h3 class="policy-subtitle">1. جمع المعلومات</h3>
                    <p class="about__text">نقوم بجمع المعلومات التي تقدمها لنا مباشرة عند التسجيل في المنصة أو
                        طلب استشارة، بما في ذلك الاسم، البريد الإلكتروني، وتفاصيل الحالة طفلك.</p>

                    <h3 class="policy-subtitle">2. استخدام المعلومات</h3>
                    <p class="about__text">تُستخدم المعلومات لتحسين خدماتنا، وتخصيص الخطط العلاجية، والتواصل معك
                        بشأن التحديثات والخدمات الجديدة.</p>

                    <h3 class="policy-subtitle">3. حماية البيانات</h3>
                    <p class="about__text">نطبق إجراءات أمنية متقدمة لضمان عدم تعرض بياناتك للفقدان أو الوصول
                        غير المصرح به.</p>
                </div>
            </div>
            <!-- Thematic Image -->
            <div class="about__image-wrapper">
                <img src="{{ asset('images/privacy-policy.png') }}" alt="سياسة الخصوصية" class="about__image">
            </div>
        </div>
    </div>
</section>

@include('partials.trust-cards')
@include('partials.newsletter')
@endsection
