<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Requests\CheckoutRequest;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(Request $request): View
    {
        $serviceSlugOrId = $request->query('service');
        $selectedService = null;

        if ($serviceSlugOrId) {
            $selectedService = Service::where('slug', $serviceSlugOrId)
                ->orWhere('id', $serviceSlugOrId)
                ->first();
        }

        if (!$selectedService) {
            $selectedService = Service::where('is_active', true)->first();
        }

        $services = Service::where('is_active', true)->get();
        $user = $request->user();

        return view('pages.checkout', compact('selectedService', 'services', 'user'));
    }

    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صالح أو منتهي الصلاحية.',
            ], 422);
        }

        $amount = (float) $request->amount;
        $discount = $coupon->calculateDiscount($amount);
        $newTotal = max(0, $amount - $discount);

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق كود الخصم بنجاح ✓',
            'discount' => $discount,
            'new_total' => $newTotal,
            'coupon_code' => $coupon->code,
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse|JsonResponse
    {
        $service = Service::findOrFail($request->service_id);
        $subtotal = (float) $service->price;
        $discount = 0.0;
        $couponId = null;

        // Verify coupon server-side
        if ($request->filled('promo_code')) {
            $coupon = Coupon::where('code', strtoupper(trim($request->promo_code)))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
                $couponId = $coupon->id;
                $coupon->increment('used_count');
            }
        }

        $total = max(0, round($subtotal - $discount, 2));

        // Get or authenticate user
        $user = Auth::user();
        if (!$user) {
            // Find user by phone/email or create new account for guest
            $email = 'user_' . Str::random(6) . '@alamaal.com';
            $user = User::firstOrCreate(
                ['phone' => $request->customer_phone],
                [
                    'name' => $request->customer_name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(12)),
                ]
            );
            Auth::login($user);
        }

        $order = Order::create([
            'order_number' => (string) random_int(100000, 999999),
            'user_id' => $user->id,
            'service_id' => $service->id,
            'coupon_id' => $couponId,
            'request_title' => $request->order_title,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'preferred_contact_time' => $request->preferred_contact_time,
            'notes' => $request->notes,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => PaymentMethod::tryFrom($request->payment) ?? PaymentMethod::Visa,
            'payment_status' => PaymentStatus::Paid,
            'status' => OrderStatus::Pending,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم استلام طلبك بنجاح! رقم الطلب #' . $order->order_number,
                'redirect_url' => route('orders.show', $order->id),
            ]);
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'تم استلام طلبك وتأكيد الدفع بنجاح! رقم الطلب: #' . $order->order_number);
    }
}
