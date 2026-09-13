@extends('layouts.admin')

@section('title', 'إدارة كوبونات الخصم | لوحة التحكم')
@section('page_title', 'إدارة كوبونات الخصم')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px;">
    <!-- Coupons Table -->
    <div class="admin-table-card">
        <div class="admin-table-header">
            <h3 class="admin-table-title">قائمة الكوبونات ({{ $coupons->count() }})</h3>
        </div>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>الكود</th>
                        <th>نوع الخصم</th>
                        <th>القيمة</th>
                        <th>الاستخدامات</th>
                        <th>الحالة</th>
                        <th>الصلاحية</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td><strong style="font-family: monospace; font-size: 1.1rem; color: #27AE60;">{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->type === 'percentage' ? 'نسبة مئوية' : 'مبلغ ثابت' }}</td>
                            <td>{{ $coupon->type === 'percentage' ? $coupon->value . '%' : number_format($coupon->value, 0) . ' ريال' }}</td>
                            <td>{{ $coupon->used_count }} {{ $coupon->usage_limit ? '/ ' . $coupon->usage_limit : '' }}</td>
                            <td>
                                @if($coupon->is_active)
                                    <span class="status-badge status-badge--completed">مفعل</span>
                                @else
                                    <span class="status-badge status-badge--cancelled">معطل</span>
                                @endif
                            </td>
                            <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'دائم' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكوبون؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--gray" style="padding: 4px 10px; font-size: 0.8rem; background: #dc3545; color: #fff;">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #888; padding: 30px;">لا توجد كوبونات مضافة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Coupon Form -->
    <div class="admin-table-card" style="padding: 25px;">
        <h3 style="font-size: 1.1rem; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">+ إضافة كوبون جديد</h3>

        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">كود الخصم (Code)</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="مثال: HOPE20" class="form-input" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px; text-transform: uppercase;" required>
                @error('code')
                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">نوع الخصم</label>
                <select name="type" class="form-select" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;" required>
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ريال)</option>
                </select>
                @error('type')
                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">قيمة الخصم</label>
                <input type="number" step="0.01" name="value" value="{{ old('value') }}" placeholder="مثال: 20 أو 50" class="form-input" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;" required>
                @error('value')
                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">الحد الأقصى للاستخدام (اختياري)</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="اتركه فارغاً لعدد لا نهائي" class="form-input" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px;">تاريخ الانتهاء (اختياري)</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="form-input" style="width: 100%; height: 40px; border: 1px solid #ddd; border-radius: 8px; padding: 0 10px;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <span>كوبون فعال فوراً</span>
                </label>
            </div>

            <button type="submit" class="btn btn--primary" style="width: 100%; padding: 10px;">إنشاء الكوبون</button>
        </form>
    </div>
</div>
@endsection
