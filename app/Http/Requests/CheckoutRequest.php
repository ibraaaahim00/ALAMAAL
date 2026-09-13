<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'order_title' => ['required', 'string', 'max:255'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'preferred_contact_time' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'promo_code' => ['nullable', 'string', 'max:50'],
            'payment' => ['required', 'string', 'in:visa,mastercard,apple,mada'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'يرجى اختيار الخدمة المطلوبة.',
            'order_title.required' => 'حقل عنوان الطلب مطلوب.',
            'customer_name.required' => 'حقل الاسم مطلوب.',
            'customer_phone.required' => 'حقل رقم الجوال مطلوب.',
            'payment.required' => 'يرجى اختيار طريقة الدفع.',
        ];
    }
}
