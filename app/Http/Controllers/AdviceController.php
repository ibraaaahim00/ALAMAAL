<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdviceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Advice::where('is_published', true);

        // Filter by Year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        // Filter by Month
        if ($request->filled('month')) {
            $query->where('month', strtolower($request->month));
        }

        // Search
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // Sort
        if ($request->get('sort') === 'oldest') {
            $query->oldest('published_at');
        } else {
            $query->latest('published_at');
        }

        $advices = $query->paginate(6)->withQueryString();

        // Calculate year counts for sidebar badges
        $yearCounts = Advice::where('is_published', true)
            ->select('year', DB::raw('count(*) as total'))
            ->groupBy('year')
            ->pluck('total', 'year');

        return view('pages.advices.index', compact('advices', 'yearCounts'));
    }
}
