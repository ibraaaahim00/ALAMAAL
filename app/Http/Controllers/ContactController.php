<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse|JsonResponse
    {
        ContactMessage::create([
            'full_name' => $request->fullName,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'new',
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم استلام رسالتك بنجاح! سنقوم بالتواصل معك في أقرب وقت.',
            ]);
        }

        return back()->with('success', 'تم استلام رسالتك بنجاح! سنقوم بالتواصل معك في أقرب وقت.');
    }
}
