<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\ActivityLog;
use App\Models\MemberProfile;
use App\Services\LocationService;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function __construct(
        protected MemberService $memberService,
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of members with search, filters, sorting, and pagination.
     */
    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('viewAny', MemberProfile::class);

        $filters = $request->only([
            'search',
            'province_id',
            'city_id',
            'district_id',
            'village_id',
            'register_date',
            'sort_by',
            'sort_dir',
        ]);

        $members = $this->memberService->getMembers($filters, 10);
        $provinces = $this->locationService->getProvinces();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $members,
            ]);
        }

        return view('members.index', compact('members', 'provinces', 'filters'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create(): View
    {
        Gate::authorize('create', MemberProfile::class);

        $provinces = $this->locationService->getProvinces();

        return view('members.create', compact('provinces'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(StoreMemberRequest $request): RedirectResponse|JsonResponse
    {
        Gate::authorize('create', MemberProfile::class);

        $member = $this->memberService->createMember(
            $request->validated(),
            $request->user()->id
        );

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'create_member',
            'description' => "Created Member profile: {$member->member_number}",
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Member created successfully.',
                'data' => $member,
            ], 201);
        }

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified member.
     */
    public function show(MemberProfile $member, Request $request): View|JsonResponse
    {
        Gate::authorize('view', $member);

        $member->load(['user', 'province', 'city', 'district', 'village', 'creator']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $member,
            ]);
        }

        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(MemberProfile $member): View
    {
        Gate::authorize('update', $member);

        $member->load(['user', 'province', 'city', 'district', 'village']);
        $provinces = $this->locationService->getProvinces();
        $cities = $this->locationService->getCitiesByProvince($member->province_id);
        $districts = $this->locationService->getDistrictsByCity($member->city_id);
        $villages = $this->locationService->getVillagesByDistrict($member->district_id);

        return view('members.edit', compact('member', 'provinces', 'cities', 'districts', 'villages'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(UpdateMemberRequest $request, MemberProfile $member): RedirectResponse|JsonResponse
    {
        Gate::authorize('update', $member);

        $updatedMember = $this->memberService->updateMember($member, $request->validated());

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'update_member',
            'description' => "Updated Member profile: {$updatedMember->member_number}",
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Member updated successfully.',
                'data' => $updatedMember,
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(MemberProfile $member, Request $request): RedirectResponse|JsonResponse
    {
        Gate::authorize('delete', $member);

        $memberNumber = $member->member_number;
        $this->memberService->deleteMember($member);

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'delete_member',
            'description' => "Deleted Member profile: {$memberNumber}",
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Member deleted successfully.',
            ]);
        }

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
