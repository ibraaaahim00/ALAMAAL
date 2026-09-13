@extends('layouts.app')

@section('title', 'جسر الأمل | تفاصيل الخطة #' . $order->order_number)
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - تفاصيل الخطة')

@section('content')
<!-- ============================================
     BREADCRUMB SECTION
============================================= -->
<section class="page-header" id="page-header">
    <div class="container">
        <div class="breadcrumb breadcrumb--details">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <a href="{{ route('orders.index') }}">الطلبات</a>
            <i class="fas fa-chevron-left"></i>
            <span class="active">عرض تفاصيل الخطة</span>
        </div>
    </div>
</section>

<!-- ============================================
     ORDER DETAILS SECTION
============================================= -->
<section class="order-details-section">
    <div class="container">
        @include('partials.alerts')

        <!-- Main Container -->
        <div class="order-details-card">

            <!-- Header -->
            <div class="order-details__header">
                <h2 class="order-details__title">{{ $order->service->title }}</h2>
                <span class="status-badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
            </div>

            <!-- Meta Info Data -->
            <div class="order-details__info">
                <div class="order-details__row">
                    <span class="order-details__label">رقم الطلب :</span>
                    <span class="order-details__value">#{{ $order->order_number }}</span>
                </div>
                <div class="order-details__row">
                    <span class="order-details__label">الأخصائي المعين :</span>
                    <span class="order-details__value">{{ $order->specialist ? $order->specialist->name : 'قيد التعيين' }}</span>
                </div>
                <div class="order-details__row">
                    <span class="order-details__label">المبلغ :</span>
                    <span class="order-details__value">{{ number_format($order->total_amount, 0) }} ريال</span>
                </div>
                <div class="order-details__row">
                    <span class="order-details__label">حالة الدفع :</span>
                    <span class="order-details__value">{{ $order->payment_status->label() }}</span>
                </div>
            </div>

            <!-- Management Response / Treatment Plan -->
            @if($order->management_response || $order->treatment_plan)
                <div class="order-details__response">
                    <h3 class="order-details__response-title">رد الإدارة والخطة العلاجية :</h3>
                    <p class="order-details__response-text">
                        {{ $order->management_response ?? $order->treatment_plan }}
                    </p>
                </div>
            @else
                <div class="order-details__response">
                    <h3 class="order-details__response-title">رد الإدارة :</h3>
                    <p class="order-details__response-text" style="color: #888;">
                        طلبك قيد المراجعة وإعداد الخطة العلاجية من قِبل الأخصائي. سيتم إضافة الخطة والملفات المرفقة فور اكتمالها.
                    </p>
                </div>
            @endif

            <!-- Attached Files -->
            @if($order->attachments->count() > 0)
                <div class="order-details__attachments">
                    @foreach($order->attachments as $attachment)
                        <div class="attached-file">
                            <div class="attached-file__icon">
                                @if($attachment->file_type === 'image')
                                    <i class="fas fa-image"></i>
                                @elseif($attachment->file_type === 'video')
                                    <i class="fas fa-video"></i>
                                @else
                                    <i class="fas fa-file-pdf"></i>
                                @endif
                            </div>
                            <div class="attached-file__info">
                                <span class="attached-file__name">{{ $attachment->file_name }}</span>
                                <span class="attached-file__size">{{ $attachment->formatted_size }}</span>
                            </div>
                            <a href="{{ $attachment->file_url }}" target="_blank" download class="attached-file__remove" aria-label="تحميل الملف" style="text-decoration: none; color: inherit;">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Existing Notes List -->
            @if($order->notes->count() > 0)
                <div style="margin-top: 25px; border-top: 1px solid #eee; padding-top: 20px;">
                    <h4 style="font-size: 1.1rem; margin-bottom: 15px; color: #333;">الملاحظات السابقة:</h4>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($order->notes as $note)
                            <div style="background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 10px; padding: 12px 16px;">
                                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #888; margin-bottom: 6px;">
                                    <strong>{{ $note->user->name }}</strong>
                                    <span>{{ $note->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <p style="margin: 0; color: #444; font-size: 0.95rem;">{{ $note->note }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Notes Section Form -->
            <form method="POST" action="{{ route('orders.notes.store', $order) }}" style="margin-top: 20px;">
                @csrf
                <div class="order-details__notes">
                    <label for="orderNotes" class="order-details__label--big">إضافة ملاحظة جديدة</label>
                    <textarea id="orderNotes" name="note" class="form-textarea" placeholder="اكتب نص الرسالة هنا..." rows="4" required></textarea>
                    @error('note')
                        <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <div style="text-align: left; margin-top: 10px;">
                    <button type="submit" class="btn btn--primary" style="padding: 8px 24px;">إرسال الملاحظة</button>
                </div>
            </form>

            <!-- Rating Section -->
            @if($order->status->value === 'completed')
                <div class="order-details__rating" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <span class="order-details__label--big">أضف تقييمك للخدمة</span>
                    <form method="POST" action="{{ route('orders.reviews.store', $order) }}" id="orderReviewForm" style="margin-top: 10px;">
                        @csrf
                        <input type="hidden" name="rating" id="reviewRatingInput" value="{{ $order->review?->rating ?? 5 }}">
                        <div class="rating-stars" id="starRatingGroup" style="cursor: pointer;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ ($order->review?->rating ?? 5) >= $i ? 'active text-warning' : 'text-muted' }}" data-value="{{ $i }}" style="font-size: 1.4rem; margin-inline-end: 4px;"></i>
                            @endfor
                        </div>
                        <div style="margin-top: 12px;">
                            <textarea name="comment" class="form-textarea" placeholder="اكتب تعليقك على جودة الخدمة والأخصائي..." rows="3">{{ old('comment', $order->review?->comment) }}</textarea>
                        </div>
                        <div style="text-align: left; margin-top: 10px;">
                            <button type="submit" class="btn btn--primary" style="padding: 8px 24px;">حفظ التقييم</button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</section>

@include('partials.trust-cards', ['bgClass' => 'bg-light'])
@include('partials.newsletter', ['altClass' => 'newsletter--alt'])
@endsection

@push('scripts')
<script>
const stars = document.querySelectorAll('#starRatingGroup i');
const ratingInput = document.getElementById('reviewRatingInput');

if (stars.length && ratingInput) {
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const val = parseInt(this.getAttribute('data-value'));
            ratingInput.value = val;
            stars.forEach(s => {
                const sVal = parseInt(s.getAttribute('data-value'));
                if (sVal <= val) {
                    s.classList.add('active', 'text-warning');
                    s.classList.remove('text-muted');
                } else {
                    s.classList.remove('active', 'text-warning');
                    s.classList.add('text-muted');
                }
            });
        });
    });
}
</script>
@endpush
