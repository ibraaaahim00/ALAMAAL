@extends('layouts.auth')

@section('title', 'جسر الأمل | نسيت كلمة السر؟')
@section('body_id', 'forgetPasswordPage')

@section('content')
<!-- Headings -->
<div class="auth-card__header">
    <h1 class="auth-card__title">نسيت كلمة السر؟</h1>
    <p class="auth-card__subtitle">الرجاء إدخال البريد الإلكتروني الذي تستخدمه لإعادة تعيين كلمة المرور</p>
</div>

<!-- Form -->
<form class="auth-form" id="forgetPasswordForm" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
        <label for="forgetEmail">البريد الإلكتروني</label>
        <div class="input-wrapper">
            <input type="email" id="forgetEmail" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني" required autofocus>
        </div>
        @error('email')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn--primary auth-btn">إرسال</button>
</form>

<!-- Footer -->
<div class="auth-card__footer">
    <p><a href="{{ route('login') }}">العودة إلى تسجيل الدخول</a></p>
</div>
@endsection
