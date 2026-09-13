<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAttachment;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'service', 'specialist']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(function ($q) use ($term) {
                $q->where('order_number', 'like', $term)
                  ->orWhere('customer_name', 'like', $term)
                  ->orWhere('customer_phone', 'like', $term);
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $specialists = Specialist::where('is_active', true)->get();

        return view('admin.orders.index', compact('orders', 'specialists'));
    }

    public function show(Order $order): View
    {
        $order->load(['user.child', 'service', 'specialist', 'attachments', 'orderNotes.user', 'review']);
        $specialists = Specialist::where('is_active', true)->get();

        return view('admin.orders.show', compact('order', 'specialists'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,in_progress,completed,cancelled'],
            'specialist_id' => ['nullable', 'exists:specialists,id'],
            'management_response' => ['nullable', 'string'],
        ]);

        $status = OrderStatus::tryFrom($request->status) ?? $order->status;

        $order->update([
            'status' => $status,
            'specialist_id' => $request->specialist_id,
            'management_response' => $request->management_response,
            'completed_at' => ($status === OrderStatus::Completed && !$order->completed_at) ? now() : $order->completed_at,
        ]);

        return back()->with('success', 'تم تحديث بيانات الطلب بنجاح.');
    }

    public function uploadAttachment(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:51200'], // max 50MB
            'file_name' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileType = match ($extension) {
            'jpg', 'jpeg', 'png', 'svg', 'webp', 'gif' => 'image',
            'pdf' => 'pdf',
            'mp4', 'mov', 'avi', 'wmv', 'mkv' => 'video',
            default => 'pdf',
        };

        $sizeInBytes = $file->getSize();
        $sizeFormatted = $sizeInBytes > 1048576
            ? round($sizeInBytes / 1048576, 1) . ' MB'
            : round($sizeInBytes / 1024, 1) . ' KB';

        $storedPath = $file->store('order_attachments/' . $order->id, 'public');

        OrderAttachment::create([
            'order_id' => $order->id,
            'file_name' => $request->file_name ?: $file->getClientOriginalName(),
            'file_path' => $storedPath,
            'file_type' => $fileType,
            'file_size' => $sizeFormatted,
        ]);

        return back()->with('success', 'تم رفع الملف وإضافته إلى الخطة بنجاح.');
    }

    public function deleteAttachment(OrderAttachment $attachment): RedirectResponse
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        return back()->with('success', 'تم حذف الملف بنجاح.');
    }
}
