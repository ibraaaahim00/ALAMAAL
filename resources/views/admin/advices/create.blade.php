@extends('layouts.admin')

@section('title', 'إضافة نصيحة فيديو جديدة | لوحة التحكم')
@section('page_title', 'إضافة نصيحة فيديو جديدة')

@section('content')
<div class="admin-table-card" style="padding: 30px; max-width: 800px;">
    <form method="POST" action="{{ route('admin.advices.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">عنوان النصيحة</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('title')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">السنة</label>
                <select name="year" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
                    @for($y = 2026; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ old('year', 2026) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                @error('year')
                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">الشهر</label>
                <select name="month" class="form-select" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
                    @php
                        $months = [
                            'january' => 'يناير',
                            'february' => 'فبراير',
                            'march' => 'مارس',
                            'april' => 'أبريل',
                            'may' => 'مايو',
                            'june' => 'يونيو',
                            'july' => 'يوليو',
                            'august' => 'أغسطس',
                            'september' => 'سبتمبر',
                            'october' => 'أكتوبر',
                            'november' => 'نوفمبر',
                            'december' => 'ديسمبر',
                        ];
                    @endphp
                    @foreach($months as $val => $lbl)
                        <option value="{{ $val }}" {{ old('month') === $val ? 'selected' : '' }}>{{ $lbl }} ({{ ucfirst($val) }})</option>
                    @endforeach
                </select>
                @error('month')
                    <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">رابط الفيديو (YouTube Embed أو رابط فيديو)</label>
            <input type="text" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/..." class="form-input" style="width: 100%; height: 42px; border: 1px solid #ddd; border-radius: 8px; padding: 0 12px;" required>
            @error('video_url')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px;">صورة مصغرة (Thumbnail)</label>
            <input type="file" name="thumbnail" class="form-input" accept="image/*" style="width: 100%;">
            @error('thumbnail')
                <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 25px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                <span>تفعيل النصيحة على الموقع</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn--primary" style="padding: 10px 25px;">حفظ النصيحة</button>
            <a href="{{ route('admin.advices.index') }}" class="btn btn--gray" style="padding: 10px 20px;">إلغاء</a>
        </div>
    </form>
</div>
@endsection
