<?php

namespace App\Http\Controllers;

use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationalController extends Controller
{
    public function index(Request $request): View
    {
        $query = EducationalContent::where('is_published', true);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('target_category', $request->category);
        }

        if ($request->filled('q')) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm);
            });
        }

        $contents = $query->latest('published_at')->paginate(6)->withQueryString();

        return view('pages.educational.index', compact('contents'));
    }

    public function show($slug): View
    {
        $content = EducationalContent::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $content->increment('views_count');

        return view('pages.educational.show', compact('content'));
    }
}
