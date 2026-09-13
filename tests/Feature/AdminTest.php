<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_user_cannot_access_admin_panel(): void
    {
        $regularUser = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $response = $this->actingAs($regularUser)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('لوحة التحكم الرئيسية');
    }

    public function test_admin_can_create_coupon(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->actingAs($admin)->post('/admin/coupons', [
            'code' => 'SUPER50',
            'type' => 'percentage',
            'value' => 50,
            'is_active' => '1',
        ]);

        $response->assertRedirect('/admin/coupons');
        $this->assertDatabaseHas('coupons', [
            'code' => 'SUPER50',
            'value' => 50,
        ]);
    }
}
