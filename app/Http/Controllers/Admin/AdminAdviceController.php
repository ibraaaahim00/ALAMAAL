<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAdviceController extends Controller
{
    public function index(): View
    {
        $advices = Advice::latest('published_at')->paginate(15);
        return view('admin.advices.index', compact('advices'));
    }

    public function create(): View
    {
        return view('admin.advices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer'],
            'month' => ['required', 'string'],
            'published_at' => ['required', 'date'],
        ]);

        Advice::create([
            'title' => $request->title,
            'thumbnail' => $request->thumbnail ?? 'images/service-autism.png',
            'video_url' => $request->video_url ?? 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'year' => $request->year,
            'month' => strtolower($request->month),
            'published_at' => $request->published_at,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.advices.index')->with('success', 'تمت إضافة النصيحة بنجاح.');
    }

    public function destroy(Advice $advice): RedirectResponse
    {
        $advice->delete();
        return redirect()->route('admin.advices.index')->with('success', 'تم حذف النصيحة.');
    }
}
