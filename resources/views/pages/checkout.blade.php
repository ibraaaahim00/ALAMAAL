@extends('layouts.app')

@section('title', 'جسر الأمل | مراجعة الطلب والدفع')
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - مراجعة الطلب والدفع')

@section('content')
<!-- ============================================
     PAGE HEADER / BREADCRUMB
============================================= -->
<section class="page-header page-header--contact" id="page-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <a href="{{ route('services.index') }}">الخدمات</a>
            <i class="fas fa-chevron-left"></i>
            <span>مراجعة الطلب والدفع</span>
        </div>
    </div>
</section>

<!-- ============================================
     CHECKOUT STEPPER
============================================= -->
<section class="checkout" id="checkout">
    <div class="container">
        @include('partials.alerts')

        <form id="mainCheckoutForm" method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" name="applied_coupon" id="appliedCouponInput" value="{{ old('coupon_code') }}">

            <div class="checkout__wrapper">

                <!-- ======= STEP 1: Order Summary ======= -->
                <div class="checkout-step checkout-step--active" id="step1">
                    <div class="checkout-step__indicator">
                        <div class="checkout-step__number">١</div>
                        <div class="checkout-step__line"></div>
                    </div>
                    <div class="checkout-step__body">
                        <div class="checkout-step__content">
                            <div class="checkout-step__header">
                                <h2 class="checkout-step__title">ملخص الطلب</h2>
                                <p class="checkout-step__subtitle">نعرض نوع الخدمة المطلوبة ومبلغ الرسوم المستحقة</p>
                            </div>
                            <div class="checkout-step__main">
                                <div class="order-summary-card">
                                    <div class="order-summary-card__image">
                                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                                    </div>
                                    <div class="order-summary-card__details">
                                        <div class="order-summary-card__header">
                                            <h3 class="order-summary-card__title">{{ $service->title }}</h3>
                                            <span class="order-summary-card__price" id="basePriceDisplay">{{ number_format($service->price, 0) }} ريال</span>
                                        </div>
                                        <p class="order-summary-card__description">{{ $service->description }}</p>
                                    </div>
                                </div>
                                <button type="button" class="btn btn--primary checkout-step__next" data-next="2">التالي</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======= STEP 2: Request Form ======= -->
                <div class="checkout-step checkout-step--inactive" id="step2">
                    <div class="checkout-step__indicator">
                        <div class="checkout-step__number">٢</div>
                        <div class="checkout-step__line"></div>
                    </div>
                    <div class="checkout-step__body">
                        <div class="checkout-step__content">
                            <div class="checkout-step__header">
                                <h2 class="checkout-step__title">نموذج الطلب</h2>
                                <p class="checkout-step__subtitle">املأ هذا النموذج حتى يكتمل طلبك وسنقوم بالتواصل معك قريبًا</p>
                            </div>
                            <div class="checkout-step__main">
                                <div class="checkout-form" id="checkoutForm">
                                    <div class="contact-form__row">
                                        <div class="contact-form__group">
                                            <label for="orderTitle">عنوان الطلب</label>
                                            <input type="text" id="orderTitle" name="order_title" value="{{ old('order_title', 'طلب خدمة ' . $service->title) }}" placeholder="محمد احمد محمد" required>
                                            @error('order_title')
                                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="contact-form__group">
                                            <label for="orderName">الاسم</label>
                                            <input type="text" id="orderName" name="client_name" value="{{ old('client_name', auth()->user()->name ?? '') }}" placeholder="الاسم" required>
                                            @error('client_name')
                                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="contact-form__row">
                                        <div class="contact-form__group">
                                            <label for="orderPhone">رقم الجوال</label>
                                            <input type="tel" id="orderPhone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="رقم الجوال" required>
                                            @error('phone')
                                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="contact-form__group">
                                            <label for="orderTime">وقت مناسب للتواصل</label>
                                            <input type="datetime-local" id="orderTime" name="preferred_contact_time" value="{{ old('preferred_contact_time', now()->addDay()->format('Y-m-d\TH:i')) }}" required>
                                            @error('preferred_contact_time')
                                                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="contact-form__group">
                                        <label for="orderNotes">ملاحظات</label>
                                        <textarea id="orderNotes" name="notes" rows="5" placeholder="اكتب نص الرسالة هنا ...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="button" class="btn btn--primary checkout-step__next" data-next="3">التالي</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======= STEP 3: Promo Code ======= -->
                <div class="checkout-step checkout-step--inactive" id="step3">
                    <div class="checkout-step__indicator">
                        <div class="checkout-step__number">٣</div>
                        <div class="checkout-step__line"></div>
                    </div>
                    <div class="checkout-step__body">
                        <div class="checkout-step__content">
                            <div class="checkout-step__header">
                                <h2 class="checkout-step__title">الرمز الترويجي</h2>
                                <p class="checkout-step__subtitle">هل لديك رمز ترويجي ؟</p>
                            </div>
                            <div class="checkout-step__main">
                                <div class="promo-code">
                                    <div class="contact-form__group">
                                        <label for="promoCode">كود الخصم</label>
                                        <div class="promo-code__input-group">
                                            <input type="text" id="promoCode" name="coupon_code" value="{{ old('coupon_code') }}" placeholder="كود الخصم">
                                            <button type="button" class="btn btn--primary promo-code__btn" id="applyPromo">تطبيق الرمز</button>
                                        </div>
                                        <div id="promoFeedback" style="margin-top: 8px; font-weight: bold;"></div>
                                    </div>
                                    <div id="priceBreakdown" style="display: none; background: #f8f9fa; border-radius: 10px; padding: 15px; margin-top: 15px;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                            <span>السعر الأصلي:</span>
                                            <span id="origPriceSpan">{{ number_format($service->price, 0) }} ريال</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; color: #27AE60;">
                                            <span>الخصم:</span>
                                            <span id="discountAmountSpan">-0 ريال</span>
                                        </div>
                                        <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; border-top: 1px solid #ddd; padding-top: 8px;">
                                            <span>الإجمالي بعد الخصم:</span>
                                            <span id="finalPriceSpan">{{ number_format($service->price, 0) }} ريال</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn--primary checkout-step__next" data-next="4">التالي</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======= STEP 4: Payment Methods ======= -->
                <div class="checkout-step checkout-step--inactive" id="step4">
                    <div class="checkout-step__indicator">
                        <div class="checkout-step__number checkout-step__number--last">٤</div>
                    </div>
                    <div class="checkout-step__body">
                        <div class="checkout-step__content">
                            <div class="checkout-step__header">
                                <h2 class="checkout-step__title">طرق الدفع المتاحة</h2>
                                <p class="checkout-step__subtitle">اختر طريقة الدفع المناسبة لك</p>
                            </div>
                            <div class="checkout-step__main">
                                <div class="payment-methods">
                                    <label class="payment-card">
                                        <input type="radio" name="payment_method" value="visa" {{ old('payment_method', 'visa') === 'visa' ? 'checked' : '' }}>
                                        <div class="payment-card__inner">
                                            <i class="fab fa-cc-visa"></i>
                                            <span>Visa</span>
                                        </div>
                                    </label>
                                    <label class="payment-card">
                                        <input type="radio" name="payment_method" value="mastercard" {{ old('payment_method') === 'mastercard' ? 'checked' : '' }}>
                                        <div class="payment-card__inner">
                                            <i class="fab fa-cc-mastercard"></i>
                                            <span>Mastercard</span>
                                        </div>
                                    </label>
                                    <label class="payment-card">
                                        <input type="radio" name="payment_method" value="apple" {{ old('payment_method') === 'apple' ? 'checked' : '' }}>
                                        <div class="payment-card__inner">
                                            <i class="fab fa-cc-apple-pay"></i>
                                            <span>Apple Pay</span>
                                        </div>
                                    </label>
                                    <label class="payment-card">
                                        <input type="radio" name="payment_method" value="mada" {{ old('payment_method') === 'mada' ? 'checked' : '' }}>
                                        <div class="payment-card__inner">
                                            <i class="fas fa-credit-card"></i>
                                            <span>مدى</span>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 8px; display: block;">{{ $message }}</span>
                                @enderror

                                <button type="submit" class="btn btn--primary checkout-step__confirm" id="confirmPayment">تأكيد الدفع</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

@include('partials.trust-cards')
@include('partials.newsletter')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const promoBtn = document.getElementById('applyPromo');
    const promoInput = document.getElementById('promoCode');
    const feedback = document.getElementById('promoFeedback');
    const breakdown = document.getElementById('priceBreakdown');
    const discountSpan = document.getElementById('discountAmountSpan');
    const finalPriceSpan = document.getElementById('finalPriceSpan');
    const appliedInput = document.getElementById('appliedCouponInput');

    if (promoBtn && promoInput) {
        promoBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            const code = promoInput.value.trim();
            if (!code) {
                feedback.textContent = 'الرجاء إدخال كود الخصم';
                feedback.style.color = '#e74c3c';
                return;
            }

            feedback.textContent = 'جاري التحقق...';
            feedback.style.color = '#333';

            try {
                const res = await fetch('{{ route('checkout.validate-coupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        code: code,
                        service_id: {{ $service->id }}
                    })
                });

                const data = await res.json();
                if (data.valid) {
                    feedback.textContent = data.message + ' ✓';
                    feedback.style.color = '#27AE60';
                    appliedInput.value = code;

                    breakdown.style.display = 'block';
                    discountSpan.textContent = '-' + data.discount_amount + ' ريال';
                    finalPriceSpan.textContent = data.final_amount + ' ريال';
                } else {
                    feedback.textContent = data.message;
                    feedback.style.color = '#e74c3c';
                    breakdown.style.display = 'none';
                    appliedInput.value = '';
                }
            } catch (err) {
                feedback.textContent = 'حدث خطأ أثناء التحقق من الكوبون';
                feedback.style.color = '#e74c3c';
            }
        });
    }
});
</script>
@endpush
