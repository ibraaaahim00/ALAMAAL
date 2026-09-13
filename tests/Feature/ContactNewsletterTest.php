<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactNewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submits_and_stores_message(): void
    {
        $response = $this->post('/contact', [
            'name' => 'محمد الأحمد',
            'phone' => '0507654321',
            'email' => 'mohamed@example.com',
            'message' => 'أود الاستفسار عن برامج التخاطب للأطفال.',
        ]);

        $response->assertRedirect('/contact');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'محمد الأحمد',
            'email' => 'mohamed@example.com',
        ]);
    }

    public function test_newsletter_subscription_stores_subscriber(): void
    {
        $response = $this->postJson('/newsletter', [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'subscriber@example.com',
        ]);
    }
}
