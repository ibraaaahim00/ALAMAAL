<?php

namespace Tests\Feature;

use App\Enums\BehavioralChallenge;
use App\Enums\ChildCondition;
use App\Enums\ChildGender;
use App\Enums\DesiredGoal;
use App\Enums\IndependenceLevel;
use App\Enums\SpeechLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee('الصفحة الشخصية');
        $response->assertSee('معلومات طفلي');
    }

    public function test_user_can_update_profile_and_child_info(): void
    {
        $user = User::factory()->create([
            'name' => 'سعد محمد',
            'phone' => '0501112233',
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'سعد بن محمد المحدث',
            'phone' => '0509998877',
            'email' => $user->email,
            'child_name' => 'خالد سعد',
            'child_date_of_birth' => '2019-05-15',
            'child_gender' => ChildGender::MALE->value,
            'child_condition' => ChildCondition::AUTISM->value,
            'child_speech_level' => SpeechLevel::MEDIUM->value,
            'child_behavioral_challenge' => BehavioralChallenge::HYPERACTIVITY->value,
            'child_independence_level' => IndependenceLevel::PARTIALLY->value,
            'child_desired_goal' => DesiredGoal::COMMUNICATION->value,
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'سعد بن محمد المحدث',
            'phone' => '0509998877',
        ]);

        $this->assertDatabaseHas('children', [
            'user_id' => $user->id,
            'name' => 'خالد سعد',
            'gender' => ChildGender::MALE->value,
            'condition' => ChildCondition::AUTISM->value,
        ]);
    }
}
