@extends('layouts.app')

@section('title', 'جسر الأمل | الصفحة الشخصية')
@section('meta_description', 'جسر الأمل لذوي الاحتياجات الخاصة - الصفحة الشخصية')

@section('content')
<!-- ============================================
     BREADCRUMB SECTION
============================================= -->
<section class="breadcrumb-section">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">الرئيسية</a>
            <i class="fas fa-chevron-left"></i>
            <span class="active">الصفحة الشخصية</span>
        </div>
    </div>
</section>

<!-- ============================================
     PERSONAL PROFILE SECTION
============================================= -->
<section class="personal-page">
    <div class="container">
        @include('partials.alerts')

        <form class="personal-form" id="personalProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Header: Avatar -->
            <div class="profile-header">
                <div class="profile-header__avatar">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-header__img" id="avatarPreview">
                    <label for="avatarInput" class="profile-header__edit-btn" aria-label="تعديل الصورة" style="cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-pencil-alt"></i>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                </div>
            </div>

            <!-- Personal Information Form -->
            <div class="personal-form__grid">
                <!-- Full Name -->
                <div class="form-group">
                    <label class="form-label" for="profileName">الاسم</label>
                    <input type="text" id="profileName" name="name" class="form-input" placeholder="الاسم" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Mobile Number -->
                <div class="form-group">
                    <label class="form-label" for="profilePhone">رقم الجوال</label>
                    <input type="tel" id="profilePhone" name="phone" class="form-input" placeholder="رقم الجوال" value="{{ old('phone', $user->phone) }}" required>
                    @error('phone')
                        <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="profileEmail">البريد الإلكتروني</label>
                    <input type="email" id="profileEmail" name="email" class="form-input" placeholder="البريد الإلكتروني" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="profilePassword">كلمة المرور الجديدة (اختياري)</label>
                    <div class="form-input-wrapper">
                        <input type="password" id="profilePassword" name="password" class="form-input" placeholder="اتركها فارغة إذا لم ترد التغيير">
                        <button type="button" class="form-input-toggle"><i class="fas fa-eye-slash"></i></button>
                    </div>
                    @error('password')
                        <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Child Information Section -->
            <div class="child-info">
                <h2 class="child-info__title">معلومات طفلي</h2>
                <div class="child-info__grid">
                    <!-- Child's Name -->
                    <div class="form-group">
                        <label class="form-label" for="childName">اسم الطفل</label>
                        <input type="text" id="childName" name="child_name" class="form-input" placeholder="اسم الطفل" value="{{ old('child_name', $child?->name) }}">
                        @error('child_name')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Date of Birth -->
                    <div class="form-group">
                        <label class="form-label" for="childDob">تاريخ الميلاد</label>
                        <div class="form-input-wrapper">
                            <input type="date" id="childDob" name="child_date_of_birth" class="form-input" placeholder="يوم / شهر / سنة" value="{{ old('child_date_of_birth', $child?->date_of_birth?->format('Y-m-d')) }}">
                            <i class="fas fa-calendar-alt form-icon"></i>
                        </div>
                        @error('child_date_of_birth')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Gender -->
                    <div class="form-group">
                        <label class="form-label" for="childGender">الجنس</label>
                        <select class="form-select" id="childGender" name="child_gender">
                            <option value="" disabled {{ old('child_gender', $child?->gender?->value) ? '' : 'selected' }}>اختر الجنس</option>
                            <option value="male" {{ old('child_gender', $child?->gender?->value) === 'male' ? 'selected' : '' }}>ذكر</option>
                            <option value="female" {{ old('child_gender', $child?->gender?->value) === 'female' ? 'selected' : '' }}>أنثى</option>
                        </select>
                        @error('child_gender')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Case/Condition -->
                    <div class="form-group">
                        <label class="form-label" for="childCondition">الحالة</label>
                        <select class="form-select" id="childCondition" name="child_condition">
                            <option value="" disabled {{ old('child_condition', $child?->condition?->value) ? '' : 'selected' }}>اختر الحالة</option>
                            <option value="autism" {{ old('child_condition', $child?->condition?->value) === 'autism' ? 'selected' : '' }}>طيف توحد</option>
                            <option value="down" {{ old('child_condition', $child?->condition?->value) === 'down' ? 'selected' : '' }}>متلازمة داون</option>
                        </select>
                        @error('child_condition')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Speech Level -->
                    <div class="form-group">
                        <label class="form-label" for="childSpeechLevel">مستوى النطق</label>
                        <select class="form-select" id="childSpeechLevel" name="child_speech_level">
                            <option value="" disabled {{ old('child_speech_level', $child?->speech_level?->value) ? '' : 'selected' }}>اختر مستوى النطق</option>
                            <option value="none" {{ old('child_speech_level', $child?->speech_level?->value) === 'none' ? 'selected' : '' }}>لا ينطق</option>
                            <option value="low" {{ old('child_speech_level', $child?->speech_level?->value) === 'low' ? 'selected' : '' }}>كلمات بسيطة</option>
                            <option value="medium" {{ old('child_speech_level', $child?->speech_level?->value) === 'medium' ? 'selected' : '' }}>جمل قصيرة</option>
                            <option value="high" {{ old('child_speech_level', $child?->speech_level?->value) === 'high' ? 'selected' : '' }}>يتحدث بطلاقة</option>
                        </select>
                        @error('child_speech_level')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Behavioral Challenge -->
                    <div class="form-group">
                        <label class="form-label" for="childBehavioralChallenge">التحدي السلوكي الأبرز</label>
                        <select class="form-select" id="childBehavioralChallenge" name="child_behavioral_challenge">
                            <option value="" disabled {{ old('child_behavioral_challenge', $child?->behavioral_challenge?->value) ? '' : 'selected' }}>اختر التحدي السلوكي الأبرز</option>
                            <option value="hyperactivity" {{ old('child_behavioral_challenge', $child?->behavioral_challenge?->value) === 'hyperactivity' ? 'selected' : '' }}>فرط حركة</option>
                            <option value="aggression" {{ old('child_behavioral_challenge', $child?->behavioral_challenge?->value) === 'aggression' ? 'selected' : '' }}>عدوانية</option>
                            <option value="shyness" {{ old('child_behavioral_challenge', $child?->behavioral_challenge?->value) === 'shyness' ? 'selected' : '' }}>خجل اجتماعي</option>
                        </select>
                        @error('child_behavioral_challenge')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Independence -->
                    <div class="form-group">
                        <label class="form-label" for="childIndependenceLevel">الاستقلالية</label>
                        <select class="form-select" id="childIndependenceLevel" name="child_independence_level">
                            <option value="" disabled {{ old('child_independence_level', $child?->independence_level?->value) ? '' : 'selected' }}>اختر الاستقلالية</option>
                            <option value="dependent" {{ old('child_independence_level', $child?->independence_level?->value) === 'dependent' ? 'selected' : '' }}>غير مستقل</option>
                            <option value="partially" {{ old('child_independence_level', $child?->independence_level?->value) === 'partially' ? 'selected' : '' }}>مستقل جزئياً</option>
                            <option value="independent" {{ old('child_independence_level', $child?->independence_level?->value) === 'independent' ? 'selected' : '' }}>مستقل كلياً</option>
                        </select>
                        @error('child_independence_level')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Desired Goal -->
                    <div class="form-group">
                        <label class="form-label" for="childDesiredGoal">الهدف المطلوب</label>
                        <select class="form-select" id="childDesiredGoal" name="child_desired_goal">
                            <option value="" disabled {{ old('child_desired_goal', $child?->desired_goal?->value) ? '' : 'selected' }}>اختر الهدف المطلوب</option>
                            <option value="communication" {{ old('child_desired_goal', $child?->desired_goal?->value) === 'communication' ? 'selected' : '' }}>تحسين التواصل</option>
                            <option value="behavior" {{ old('child_desired_goal', $child?->desired_goal?->value) === 'behavior' ? 'selected' : '' }}>تعديل السلوك</option>
                            <option value="skills" {{ old('child_desired_goal', $child?->desired_goal?->value) === 'skills' ? 'selected' : '' }}>تطوير المهارات</option>
                        </select>
                        @error('child_desired_goal')
                            <span class="form-error-msg" style="color: #dc3545; font-size: 0.85rem; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="form-actions">
                <button type="submit" class="btn btn--save">حفظ</button>
            </div>
        </form>
    </div>
</section>

@include('partials.trust-cards', ['bgClass' => 'bg-light'])
@include('partials.newsletter', ['altClass' => 'newsletter--alt'])
@endsection

@push('scripts')
<script>
const avatarInput = document.getElementById('avatarInput');
if (avatarInput) {
    avatarInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}
</script>
@endpush
