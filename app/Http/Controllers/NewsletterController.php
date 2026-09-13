<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        ]);

        NewsletterSubscriber::firstOrCreate(
            ['email' => strtolower(trim($request->email))],
            ['is_active' => true]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم التسجيل بنجاح ✓',
            ]);
        }

        return back()->with('success', 'تم الاشتراك في القائمة البريدية بنجاح!');
    }
}
