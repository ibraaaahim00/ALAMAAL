@extends('layouts.auth')

@section('title', 'جسر الأمل | إنشاء حساب جديد')
@section('body_id', 'registerPage')

@section('content')
<!-- Headings -->
<div class="auth-card__header">
    <h1 class="auth-card__title">سجل الآن معنا مجانا</h1>
    <p class="auth-card__subtitle">أدخل لإنشاء حساب جديد للمتابعة</p>
</div>

<!-- Form -->
<form class="auth-form" id="registerForm" method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label for="regName">الاسم</label>
        <div class="input-wrapper">
            <input type="text" id="regName" name="name" value="{{ old('name') }}" placeholder="الاسم" required>
        </div>
        @error('name')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="regMobile">رقم الجوال</label>
        <div class="input-wrapper">
            <input type="tel" id="regMobile" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال" required>
        </div>
        @error('phone')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="regEmail">البريد الإلكتروني</label>
        <div class="input-wrapper">
            <input type="email" id="regEmail" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required>
        </div>
        @error('email')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="regPassword">كلمة المرور</label>
        <div class="input-wrapper">
            <input type="password" id="regPassword" name="password" placeholder="كلمة المرور" required>
            <button type="button" class="password-toggle" aria-label="تبديل رؤية كلمة المرور">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="auth-form__options">
        <label class="custom-checkbox">
            <input type="checkbox" id="termsAgree" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
            <span class="checkbox-mark"></span>
            <span class="checkbox-label">الموافقة على <a href="{{ route('privacy') }}" target="_blank" style="color: inherit; text-decoration: underline;">الشروط والأحكام</a></span>
        </label>
        @error('terms')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn--primary auth-btn">إنشاء حساب جديد</button>
</form>

<!-- Footer -->
<div class="auth-card__footer">
    <p>لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a></p>
</div>
@endsection
