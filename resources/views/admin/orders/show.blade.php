@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . $order->order_number . ' | لوحة التحكم')
@section('page_title', 'تفاصيل وإدارة الطلب #' . $order->order_number)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
    <!-- Main Column: Plan, Management Response, Attachments -->
    <div>
        <!-- Order & Client Info Card -->
        <div class="admin-table-card" style="padding: 25px; margin-bottom: 25px;">
            <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">بيانات الطلب والعميل</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">الخدمة:</span>
                    <strong>{{ $order->service->title }}</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">اسم العميل:</span>
                    <strong>{{ $order->client_name }}</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">رقم الجوال:</span>
                    <strong>{{ $order->phone }}</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">وقت التواصل المفضل:</span>
                    <strong>{{ $order->preferred_contact_time ? $order->preferred_contact_time->format('Y-m-d H:i') : 'غير محدد' }}</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">المبلغ الإجمالي:</span>
                    <strong>{{ number_format($order->total_amount, 0) }} ريال</strong>
                    @if($order->discount_amount > 0)
                        <span style="color: #27AE60; font-size: 0.85rem;">(خصم: {{ number_format($order->discount_amount, 0) }} ريال عبر {{ $order->coupon?->code }})</span>
                    @endif
                </div>
                <div>
                    <span style="display: block; font-size: 0.85rem; color: #888;">طريقة الدفع:</span>
                    <strong>{{ $order->payment_method->label() }}</strong>
                </div>
            </div>

            @if($order->notes_client)
                <div style="margin-top: 15px; background: #fafafa; padding: 12px; border-radius: 8px;">
                    <span style="display: block; font-size: 0.85rem; color: #888; margin-bottom: 4px;">ملاحظات العميل عند الطلب:</span>
                    <p style="margin: 0; color: #333;">{{ $order->notes_client }}</p>
                </div>
            @endif
        </div>

        <!-- Management Response & Treatment Plan Update Form -->
        <div class="admin-table-card" style="padding: 25px; margin-bottom: 25px;">
            <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">الخطة العلاجية ورد الإدارة</h3>

            <form method="POST" action="{{ route('admin.orders.update-plan', $order) }}">
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px;">رد الإدارة وتفاصيل الخطة</label>
                    <textarea name="management_response" rows="6" class="form-input" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; font-family: inherit;">{{ old('management_response', $order->management_response ?? $order->treatment_plan) }}</textarea>
                </div>

                <button type="submit" class="btn btn--primary">حفظ تفاصيل الخطة والرد</button>
            </form>
        </div>

        <!-- Attachments Section -->
        <div class="admin-table-card" style="padding: 25px; margin-bottom: 25px;">
            <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">الملفات والمرفقات (صور، تقارير PDF، فيديوهات)</h3>

            <!-- Existing Attachments -->
            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                @forelse($order->attachments as $attachment)
                    <div style="display: flex; align-items: center; justify-content: space-between; background: #f9f9f9; padding: 10px 15px; border-radius: 8px; border: 1px solid #eee;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($attachment->file_type === 'image')
                                <i class="fas fa-image" style="color: #3498db; font-size: 1.2rem;"></i>
                            @elseif($attachment->file_type === 'video')
                                <i class="fas fa-video" style="color: #e74c3c; font-size: 1.2rem;"></i>
                            @else
                                <i class="fas fa-file-pdf" style="color: #e67e22; font-size: 1.2rem;"></i>
                            @endif
                            <a href="{{ $attachment->file_url }}" target="_blank" style="font-weight: 500; color: #333; text-decoration: none;">{{ $attachment->file_name }}</a>
                            <span style="font-size: 0.8rem; color: #888;">({{ $attachment->formatted_size }})</span>
                        </div>
                        <form method="POST" action="{{ route('admin.orders.attachments.destroy', [$order, $attachment]) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 5px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p style="color: #888; margin: 0;">لا توجد ملفات مرفقة لهذا الطلب حتى الآن.</p>
                @endforelse
            </div>

            <!-- Upload New Attachment -->
            <form method="POST" action="{{ route('admin.orders.attachments.store', $order) }}" enctype="multipart/form-data" style="background: #fafafa; padding: 15px; border-radius: 8px; border: 1px dashed #ccc;">
                @csrf
                <div style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 6px;">اختر ملف (صورة، PDF، فيديو حتى 50MB)</label>
                        <input type="file" name="attachment_file" class="form-input" required style="width: 100%;">
                    </div>
                    <div style="flex: 1; min-width: 150px;">
                        <label style="display: block; font-size: 0.85rem; margin-bottom: 6px;">اسم توضيحي للملف (اختياري)</label>
                        <input type="text" name="display_name" class="form-input" placeholder="مثال: التقرير التشخيصي النهائي" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;">
                    </div>
                    <button type="submit" class="btn btn--primary" style="height: 40px; padding: 0 20px;">رفع الملف</button>
                </div>
            </form>
        </div>

        <!-- Notes / Timeline -->
        <div class="admin-table-card" style="padding: 25px;">
            <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">سجل الملاحظات والمحادثة</h3>

            <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                @forelse($order->notes as $note)
                    <div style="background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 8px; padding: 12px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #888; margin-bottom: 4px;">
                            <strong>{{ $note->user->name }} ({{ $note->user->role->value === 'admin' ? 'الإدارة' : 'ولي الأمر' }})</strong>
                            <span>{{ $note->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <p style="margin: 0; color: #333;">{{ $note->note }}</p>
                    </div>
                @empty
                    <p style="color: #888; margin: 0;">لا توجد ملاحظات مسجلة.</p>
                @endforelse
            </div>

            <!-- Add Admin Note -->
            <form method="POST" action="{{ route('admin.orders.notes.store', $order) }}">
                @csrf
                <div class="form-group" style="margin-bottom: 10px;">
                    <textarea name="note" rows="3" class="form-input" placeholder="أضف ملاحظة إدارية..." style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 10px; font-family: inherit;" required></textarea>
                </div>
                <button type="submit" class="btn btn--primary" style="padding: 6px 16px;">إضافة ملاحظة</button>
            </form>
        </div>
    </div>

    <!-- Side Column: Status, Specialist, Payment Update -->
    <div>
        <div class="admin-table-card" style="padding: 25px; margin-bottom: 25px;">
            <h3 style="font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">تحديث حالة الطلب</h3>

            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                @csrf
                @method('PATCH')

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">حالة الطلب</label>
                    <select name="status" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
                        <option value="pending" {{ $order->status->value === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="in_progress" {{ $order->status->value === 'in_progress' ? 'selected' : '' }}>جاري العمل</option>
                        <option value="completed" {{ $order->status->value === 'completed' ? 'selected' : '' }}>تم الانتهاء</option>
                        <option value="cancelled" {{ $order->status->value === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">الأخصائي المعين</label>
                    <select name="specialist_id" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
                        <option value="">-- بدون أخصائي --</option>
                        @foreach($specialists as $specialist)
                            <option value="{{ $specialist->id }}" {{ $order->specialist_id == $specialist->id ? 'selected' : '' }}>{{ $specialist->name }} ({{ $specialist->title }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">حالة الدفع</label>
                    <select name="payment_status" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
                        <option value="pending" {{ $order->payment_status->value === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="paid" {{ $order->payment_status->value === 'paid' ? 'selected' : '' }}>مدفوع</option>
                        <option value="failed" {{ $order->payment_status->value === 'failed' ? 'selected' : '' }}>فشل</option>
                        <option value="refunded" {{ $order->payment_status->value === 'refunded' ? 'selected' : '' }}>مسترد</option>
                    </select>
                </div>

                <button type="submit" class="btn btn--primary" style="width: 100%;">تحديث الحالة</button>
            </form>
        </div>

        <!-- Client Rating & Review -->
        @if($order->review)
            <div class="admin-table-card" style="padding: 25px;">
                <h3 style="font-size: 1.2rem; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">تقييم العميل</h3>
                <div style="color: #f39c12; font-size: 1.2rem; margin-bottom: 10px;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $order->review->rating >= $i ? '' : 'text-muted' }}" style="{{ $order->review->rating >= $i ? '' : 'color: #ddd;' }}"></i>
                    @endfor
                    <span style="font-size: 0.9rem; color: #333; margin-inline-start: 5px;">({{ $order->review->rating }}/5)</span>
                </div>
                <p style="margin: 0; color: #555; font-size: 0.95rem;">{{ $order->review->comment ?? 'بدون تعليق مكتوب' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
