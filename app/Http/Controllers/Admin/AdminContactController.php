<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminContactController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contact.index', compact('messages'));
    }

    public function markAsRead(ContactMessage $contact): RedirectResponse
    {
        $contact->update(['status' => 'read']);
        return back()->with('success', 'تم تعيين الرسالة كمقروءة.');
    }

    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();
        return back()->with('success', 'تم حذف الرسالة.');
    }
}
