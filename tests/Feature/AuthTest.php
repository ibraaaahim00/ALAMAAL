<?php

namespace Tests\Feature;

use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('تسجيل الدخول إلى حسابك');
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'أحمد علي',
            'phone' => '0501234567',
            'email' => 'ahmed@test.com',
            'password' => 'password123',
            'terms' => '1',
        ]);

        $response->assertRedirect('/profile');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'ahmed@test.com']);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'parent@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'parent@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/profile');
        $this->assertAuthenticatedAs($user);
    }

    public function test_forgot_password_generates_and_stores_otp(): void
    {
        $user = User::factory()->create([
            'email' => 'forgot@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'forgot@example.com',
        ]);

        $response->assertRedirect('/verify-otp');
        $this->assertDatabaseHas('password_reset_otps', [
            'email' => 'forgot@example.com',
            'is_used' => false,
        ]);
    }
}
