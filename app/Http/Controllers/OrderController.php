<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderNote;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->orders()
            ->with(['service', 'specialist'])
            ->latest()
            ->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        // Authorization check: only owner or admin can view
        if ($request->user()->id !== $order->user_id && !$request->user()->isAdmin()) {
            abort(403, 'غير مصرح لك باستعراض هذا الطلب.');
        }

        $order->load(['service', 'specialist', 'attachments', 'orderNotes.user', 'review']);

        return view('pages.orders.show', compact('order'));
    }

    public function addNote(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        if ($request->user()->id !== $order->user_id && !$request->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $note = OrderNote::create([
            'order_id' => $order->id,
            'user_id' => $request->user()->id,
            'content' => $request->input('content'),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الملاحظة بنجاح.',
                'note' => $note,
            ]);
        }

        return back()->with('success', 'تم إرسال الملاحظة بنجاح.');
    }

    public function addReview(Request $request, Order $order): RedirectResponse|JsonResponse
    {
        if ($request->user()->id !== $order->user_id) {
            abort(403);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => $request->user()->id,
                'service_id' => $order->service_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'شكرًا لتقييمك! تم حفظ التقييم بنجاح.',
            ]);
        }

        return back()->with('success', 'شكرًا لتقييمك! تم حفظ التقييم بنجاح.');
    }
}
