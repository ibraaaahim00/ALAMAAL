<?php

namespace App\Http\Controllers;

use App\Enums\BehavioralChallenge;
use App\Enums\ChildCondition;
use App\Enums\ChildGender;
use App\Enums\DesiredGoal;
use App\Enums\IndependenceLevel;
use App\Enums\SpeechLevel;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Child;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user();
        $child = $user->child ?? new Child();

        return view('pages.profile', compact('user', 'child'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Update Parent details
        $userData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_starts_with($user->avatar, 'images/') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        // 2. Update/create Child details
        $child = $user->child;
        $childData = [
            'name' => $request->child_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender ? ChildGender::tryFrom($request->gender) : null,
            'condition' => $request->condition ? ChildCondition::tryFrom($request->condition) : null,
            'speech_level' => $request->speech_level ? SpeechLevel::tryFrom($request->speech_level) : null,
            'behavioral_challenge' => $request->behavioral_challenge ? BehavioralChallenge::tryFrom($request->behavioral_challenge) : null,
            'independence' => $request->independence ? IndependenceLevel::tryFrom($request->independence) : null,
            'desired_goal' => $request->desired_goal ? DesiredGoal::tryFrom($request->desired_goal) : null,
        ];

        if ($child) {
            $child->update($childData);
        } else {
            $user->children()->create($childData);
        }

        return redirect()->route('profile')->with('success', 'تم حفظ التعديلات بنجاح!');
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:4096'],
        ]);

        $user = $request->user();

        if ($user->avatar && !str_starts_with($user->avatar, 'images/') && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'avatar_url' => Storage::disk('public')->url($path),
            'message' => 'تم تحديث الصورة الشخصية بنجاح!',
        ]);
    }
}
