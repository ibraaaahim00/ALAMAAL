@extends('layouts.admin')

@section('title', 'تعديل الخدمة | لوحة التحكم')
@section('page_title', 'تعديل الخدمة: ' . $service->title)

@section('content')
<div class="admin-table-card" style="padding: 30px; max-width: 800px;">
    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">عنوان الخدمة</label>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('title')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">نوع الخدمة</label>
            <select name="type" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
                <option value="autism" {{ old('type', $service->type->value) === 'autism' ? 'selected' : '' }}>أطفال التوحد</option>
                <option value="down" {{ old('type', $service->type->value) === 'down' ? 'selected' : '' }}>متلازمة داون</option>
                <option value="consultation" {{ old('type', $service->type->value) === 'consultation' ? 'selected' : '' }}>الاستشارات</option>
            </select>
            @error('type')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">السعر (ريال)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('price')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">وصف الخدمة</label>
            <textarea name="description" rows="4" class="form-input" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; font-family: inherit;" required>{{ old('description', $service->description) }}</textarea>
            @error('description')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">صورة الخدمة</label>
            @if($service->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ $service->image_url }}" alt="{{ $service->title }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="image" class="form-input" accept="image/*" style="width: 100%;">
            @error('image')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">ترتيب العرض</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                <span>تفعيل الخدمة على الموقع</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn--primary" style="padding: 10px 25px;">تحديث الخدمة</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn--gray" style="padding: 10px 20px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
