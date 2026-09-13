@extends('layouts.auth')

@section('title', 'جسر الأمل | رمز التحقق')
@section('body_id', 'otpPage')

@section('content')
<!-- Headings -->
<div class="auth-card__header">
    <h1 class="auth-card__title">رمز التحقق</h1>
    <p class="auth-card__subtitle">الرجاء إدخال الرمز الذي أرسلناه إلى بريدك الإلكتروني ({{ session('email', request('email')) }})</p>
    <div class="otp-timer">59:00</div>
</div>

<!-- Form -->
<form class="auth-form" id="otpForm" method="POST" action="{{ route('password.verify.post') }}">
    @csrf
    <input type="hidden" name="email" value="{{ session('email', request('email')) }}">
    <input type="hidden" id="otpCombined" name="otp" value="">

    <div class="form-group">
        <label>رمز التحقق</label>
        <div class="otp-inputs-wrapper">
            <input type="text" maxlength="1" class="otp-input" pattern="\d*" inputmode="numeric" required autofocus>
            <input type="text" maxlength="1" class="otp-input" pattern="\d*" inputmode="numeric" required>
            <input type="text" maxlength="1" class="otp-input" pattern="\d*" inputmode="numeric" required>
            <input type="text" maxlength="1" class="otp-input" pattern="\d*" inputmode="numeric" required>
        </div>
        @error('otp')
            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn--primary auth-btn">تحقق</button>
</form>

<!-- Footer -->
<div class="auth-card__footer">
    <p>
        <form method="POST" action="{{ route('password.resend') }}" style="display: inline;">
            @csrf
            <input type="hidden" name="email" value="{{ session('email', request('email')) }}">
            <button type="submit" class="resend-link" style="background:none; border:none; color:inherit; cursor:pointer; font:inherit; text-decoration:underline; padding:0;">إعادة إرسال الرمز</button>
        </form>
    </p>
</div>

@push('scripts')
<script>
document.getElementById('otpForm')?.addEventListener('submit', function(e) {
    const inputs = document.querySelectorAll('.otp-input');
    let code = '';
    inputs.forEach(input => code += input.value);
    document.getElementById('otpCombined').value = code;
});
</script>
@endpush
@endsection
