@extends('layouts.auth')

@section('title', 'جسر الأمل | إعادة تعيين كلمة المرور')
@section('body_id', 'resetPasswordPage')

@section('content')
<!-- Headings -->
<div class="auth-card__header">
    <h1 class="auth-card__title">إعادة تعيين كلمة المرور</h1>
    <p class="auth-card__subtitle">الرجاء إدخال كلمة المرور الجديدة</p>
</div>

<!-- Form -->
<form class="auth-form" id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="email" value="{{ session('email', request('email')) }}">
    <input type="hidden" name="token" value="{{ session('token', request('token')) }}">

    <div class="form-group">
        <label for="newPassword">كلمة المرور الجديدة</label>
        <div class="input-wrapper">
            <input type="password" id="newPassword" name="password" placeholder="أدخل كلمة المرور الجديدة" required autofocus>
            <button type="button" class="password-toggle">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        @error('password')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="confirmPassword">تأكيد كلمة المرور الجديدة</label>
        <div class="input-wrapper">
            <input type="password" id="confirmPassword" name="password_confirmation" placeholder="أدخل تأكيد كلمة المرور الجديدة" required>
            <button type="button" class="password-toggle">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn--primary auth-btn">حفظ</button>
</form>
@endsection
