<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\ActivityLog;
use App\Services\LocationService;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected MemberService $memberService,
        protected LocationService $locationService
    ) {}

    /**
     * Display the authenticated user's profile.
     */
    public function show(Request $request): View|JsonResponse
    {
        $user = $request->user()->load(['memberProfile.province', 'memberProfile.city', 'memberProfile.district', 'memberProfile.village']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit(Request $request): View
    {
        $user = $request->user()->load(['memberProfile.province', 'memberProfile.city', 'memberProfile.district', 'memberProfile.village']);
        $memberProfile = $user->memberProfile;

        $provinces = $this->locationService->getProvinces();
        $cities = $memberProfile ? $this->locationService->getCitiesByProvince($memberProfile->province_id) : collect();
        $districts = $memberProfile ? $this->locationService->getDistrictsByCity($memberProfile->city_id) : collect();
        $villages = $memberProfile ? $this->locationService->getVillagesByDistrict($memberProfile->district_id) : collect();

        return view('profile.edit', compact('user', 'memberProfile', 'provinces', 'cities', 'districts', 'villages'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $memberProfile = $user->memberProfile;

        if (! $memberProfile) {
            return back()->withErrors(['error' => 'Member profile not found.']);
        }

        $this->memberService->updateMember($memberProfile, $request->validated());

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'update_profile',
            'description' => 'User updated personal profile.',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'data' => $user->fresh(['memberProfile']),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the password change form.
     */
    public function editPassword(): View
    {
        return view('profile.password');
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(ChangePasswordRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'change_password',
            'description' => 'User changed password successfully.',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }
}
