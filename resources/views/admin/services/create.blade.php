@extends('layouts.admin')

@section('title', 'إضافة خدمة جديدة | لوحة التحكم')
@section('page_title', 'إضافة خدمة جديدة')

@section('content')
<div class="admin-table-card" style="padding: 30px; max-width: 800px;">
    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">عنوان الخدمة</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('title')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">نوع الخدمة</label>
            <select name="type" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
                <option value="autism" {{ old('type') === 'autism' ? 'selected' : '' }}>أطفال التوحد</option>
                <option value="down" {{ old('type') === 'down' ? 'selected' : '' }}>متلازمة داون</option>
                <option value="consultation" {{ old('type') === 'consultation' ? 'selected' : '' }}>الاستشارات</option>
            </select>
            @error('type')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">السعر (ريال)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('price')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">وصف الخدمة</label>
            <textarea name="description" rows="4" class="form-input" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; font-family: inherit;" required>{{ old('description') }}</textarea>
            @error('description')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">صورة الخدمة</label>
            <input type="file" name="image" class="form-input" accept="image/*" style="width: 100%;">
            @error('image')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">ترتيب العرض</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                <span>تفعيل الخدمة على الموقع</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn--primary" style="padding: 10px 25px;">حفظ الخدمة</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn--gray" style="padding: 10px 20px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
