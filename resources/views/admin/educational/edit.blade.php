@extends('layouts.admin')

@section('title', 'تعديل المحتوى التوعوي | لوحة التحكم')
@section('page_title', 'تعديل: ' . $educational->title)

@section('content')
<div class="admin-table-card" style="padding: 30px; max-width: 800px;">
    <form method="POST" action="{{ route('admin.educational.update', $educational) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">عنوان المقال / المحتوى</label>
            <input type="text" name="title" value="{{ old('title', $educational->title) }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('title')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">القسم</label>
            <select name="category_id" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
                <option value="">-- بدون قسم (عام) --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $educational->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">مقتطف قصير (يظهر في البطاقة)</label>
            <textarea name="excerpt" rows="2" class="form-input" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; font-family: inherit;">{{ old('excerpt', $educational->excerpt) }}</textarea>
            @error('excerpt')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">المحتوى الكامل</label>
            <textarea name="content" rows="8" class="form-input" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; font-family: inherit;" required>{{ old('content', $educational->content) }}</textarea>
            @error('content')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">الصورة البارزة</label>
            @if($educational->image)
                <div style="margin-bottom: 10px;">
                    <img src="{{ $educational->image_url }}" alt="{{ $educational->title }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="image" class="form-input" accept="image/*" style="width: 100%;">
            @error('image')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">رابط فيديو (اختياري)</label>
            <input type="url" name="video_url" value="{{ old('video_url', $educational->video_url) }}" placeholder="https://..." class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;">
            @error('video_url')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $educational->is_published) ? 'checked' : '' }}>
                <span>نشر المقال على الموقع</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn--primary" style="padding: 10px 25px;">تحديث المقال</button>
            <a href="{{ route('admin.educational.index') }}" class="btn btn--gray" style="padding: 10px 20px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
