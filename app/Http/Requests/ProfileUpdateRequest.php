<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            // Parent info
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($userId)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:6'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:4096'],

            // Child info
            'child_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'condition' => ['nullable', 'string', 'in:autism,down'],
            'speech_level' => ['nullable', 'string', 'in:none,low,medium,high'],
            'behavioral_challenge' => ['nullable', 'string', 'in:hyperactivity,aggression,shyness'],
            'independence' => ['nullable', 'string', 'in:dependent,partially,independent'],
            'desired_goal' => ['nullable', 'string', 'in:communication,behavior,skills'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'حقل الاسم مطلوب.',
            'phone.required' => 'حقل رقم الجوال مطلوب.',
            'phone.unique' => 'رقم الجوال مستخدم بالفعل.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'avatar.image' => 'يجب أن يكون الملف المرفوع صورة.',
            'avatar.max' => 'الحد الأقصى لحجم الصورة هو 4 ميجابايت.',
        ];
    }
}
