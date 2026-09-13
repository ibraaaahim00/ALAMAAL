<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationalContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEducationalController extends Controller
{
    public function index(): View
    {
        $contents = EducationalContent::latest('published_at')->paginate(15);
        return view('admin.educational.index', compact('contents'));
    }

    public function create(): View
    {
        return view('admin.educational.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_category' => ['required', 'string', 'in:autism,down,general'],
            'thumbnail' => ['nullable', 'string'],
            'video_url' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
            'guidance_steps' => ['nullable', 'string'],
            'published_at' => ['required', 'date'],
        ]);

        EducationalContent::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) ?: 'content-' . uniqid(),
            'description' => $request->description,
            'target_category' => $request->target_category,
            'thumbnail' => $request->thumbnail ?? 'images/service-autism.png',
            'video_url' => $request->video_url,
            'instructions' => $request->instructions,
            'guidance_steps' => $request->guidance_steps,
            'published_at' => $request->published_at,
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.educational.index')->with('success', 'تمت إضافة المحتوى التوعوي بنجاح.');
    }

    public function edit(EducationalContent $educational): View
    {
        return view('admin.educational.edit', ['content' => $educational]);
    }

    public function update(Request $request, EducationalContent $educational): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_category' => ['required', 'string', 'in:autism,down,general'],
            'published_at' => ['required', 'date'],
        ]);

        $educational->update([
            'title' => $request->title,
            'description' => $request->description,
            'target_category' => $request->target_category,
            'thumbnail' => $request->thumbnail ?? $educational->thumbnail,
            'video_url' => $request->video_url,
            'instructions' => $request->instructions,
            'guidance_steps' => $request->guidance_steps,
            'published_at' => $request->published_at,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.educational.index')->with('success', 'تم تحديث المحتوى التوعوي.');
    }

    public function destroy(EducationalContent $educational): RedirectResponse
    {
        $educational->delete();
        return redirect()->route('admin.educational.index')->with('success', 'تم حذف المحتوى.');
    }
}
