@extends('layouts.app')

@section('title', 'جسر الأمل | تواصل معنا')
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - تواصل معنا')

@section('content')
<!-- ============================================
     PAGE HEADER / BREADCRUMB
============================================= -->
<section class="page-header page-header--contact" id="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <span>تواصل معنا</span>
        </div>
    </div>
</section>

<!-- ============================================
     CONTACT SECTION
============================================= -->
<section class="contact" id="contact-section">
    <div class="container">
        @include('partials.alerts')

        <div class="contact__grid">
            <!-- Contact Info (Right side in RTL) -->
            <div class="contact__info">
                <h2 class="contact__info-title">تواصل معنا</h2>
                <p class="contact__info-subtitle">تواصل معنا من خلال نموذج الاتصال الخاص بنا وسنقوم بالرد عليك قريبًا</p>

                <ul class="contact__details">
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:bridge-of-hope@gmail.com">bridge-of-hope@gmail.com</a>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <div>
                            <a href="tel:+966123456789">+966 123 456 7890</a>
                            <a href="tel:+201234567890">+20 123 4567 890</a>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>الرياض، المملكة العربية السعودية</span>
                    </li>
                </ul>
            </div>

            <!-- Contact Form (Left side in RTL) -->
            <div class="contact__form-wrapper">
                <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="contact-form__row">
                        <div class="contact-form__group">
                            <label for="fullName">الاسم بالكامل</label>
                            <input type="text" id="fullName" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="محمد احمد محمد" required>
                            @error('name')
                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="contact-form__group">
                            <label for="phone">رقم الجوال</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="رقم الجوال" required>
                            @error('phone')
                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="contact-form__group">
                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="البريد الإلكتروني" required>
                        @error('email')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="contact-form__group">
                        <label for="message">الرسالة</label>
                        <textarea id="message" name="message" rows="6" placeholder="اكتب نص الرسالة هنا ..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn--primary contact-form__btn">إرسال</button>
                </form>
            </div>
        </div>
    </div>
</section>

@include('partials.trust-cards')
@include('partials.newsletter')
@endsection
