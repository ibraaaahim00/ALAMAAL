<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ServiceType;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_checkout_page(): void
    {
        $user = User::factory()->create();
        $service = Service::create([
            'title' => 'أطفال التوحد',
            'slug' => 'autism-service',
            'type' => ServiceType::AUTISM,
            'price' => 250,
            'description' => 'برامج تأهيل متخصصة',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/checkout?service=' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee('أطفال التوحد');
        $response->assertSee('250 ريال');
    }

    public function test_coupon_validation_ajax(): void
    {
        $user = User::factory()->create();
        $service = Service::create([
            'title' => 'أطفال التوحد',
            'slug' => 'autism-service',
            'type' => ServiceType::AUTISM,
            'price' => 200,
            'description' => 'برامج تأهيل متخصصة',
            'is_active' => true,
        ]);

        $coupon = Coupon::create([
            'code' => 'HOPE20',
            'type' => 'percentage',
            'value' => 20,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->postJson('/checkout/validate-coupon', [
            'code' => 'HOPE20',
            'service_id' => $service->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'valid' => true,
            'discount_amount' => 40,
            'final_amount' => 160,
        ]);
    }

    public function test_user_can_place_order(): void
    {
        $user = User::factory()->create();
        $service = Service::create([
            'title' => 'أطفال التوحد',
            'slug' => 'autism-service',
            'type' => ServiceType::AUTISM,
            'price' => 250,
            'description' => 'برامج تأهيل متخصصة',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/checkout', [
            'service_id' => $service->id,
            'order_title' => 'طلب استشارة طفل توحد',
            'client_name' => $user->name,
            'phone' => '0501234567',
            'preferred_contact_time' => now()->addDays(2)->format('Y-m-d H:i'),
            'notes' => 'يرجى التواصل مساءً',
            'payment_method' => PaymentMethod::VISA->value,
        ]);

        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'total_amount' => 250,
            'status' => OrderStatus::PENDING->value,
        ]);
    }
}
