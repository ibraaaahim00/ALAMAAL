<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\EducationalContent;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', OrderStatus::Pending)->count(),
            'in_progress_orders' => Order::where('status', OrderStatus::InProgress)->count(),
            'completed_orders' => Order::where('status', OrderStatus::Completed)->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_services' => Service::count(),
            'total_content' => EducationalContent::count(),
            'new_messages' => ContactMessage::where('status', 'new')->count(),
            'subscribers' => NewsletterSubscriber::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        $latestOrders = Order::with(['user', 'service', 'specialist'])
            ->latest()
            ->take(6)
            ->get();

        $latestMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestOrders', 'latestMessages'));
    }
}
