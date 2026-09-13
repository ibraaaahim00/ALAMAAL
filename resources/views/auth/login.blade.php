@extends('layouts.auth')

@section('title', 'جسر الأمل | تسجيل الدخول')
@section('body_id', 'loginPage')

@section('content')
<!-- Headings -->
<div class="auth-card__header">
    <h1 class="auth-card__title">تسجيل الدخول إلى حسابك</h1>
    <p class="auth-card__subtitle">مرحباً بك من جديد، أدخل للمتابعة والاستكشاف</p>
</div>

<!-- Form -->
<form class="auth-form" id="loginForm" method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label for="loginEmail">البريد الإلكتروني</label>
        <div class="input-wrapper">
            <input type="email" id="loginEmail" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required autofocus>
        </div>
        @error('email')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="loginPassword">كلمة المرور</label>
        <div class="input-wrapper">
            <input type="password" id="loginPassword" name="password" placeholder="كلمة المرور" required>
            <button type="button" class="password-toggle" aria-label="تبديل رؤية كلمة المرور">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="auth-form__options">
        <a href="{{ route('password.request') }}" class="forgot-password">نسيت كلمة السر؟</a>
    </div>

    <button type="submit" class="btn btn--primary auth-btn">تسجيل الدخول</button>
</form>

<!-- Footer -->
<div class="auth-card__footer">
    <p>ليس لديك حساب حتى الآن؟ <a href="{{ route('register') }}">سجل الآن</a></p>
</div>
@endsection
