<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StoreFrontOfficeRequest;
use App\Http\Requests\UpdateFrontOfficeRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class FrontOfficeController extends Controller
{
    /**
     * Display a listing of Front Office accounts.
     */
    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('viewAny', [User::class, 'fo']);

        $query = User::where('role', UserRole::Fo);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $frontOffices = $query->latest()->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $frontOffices]);
        }

        return view('front_office.index', compact('frontOffices'));
    }

    /**
     * Show the form for creating a new Front Office account.
     */
    public function create(): View
    {
        Gate::authorize('create', [User::class, 'fo']);

        return view('front_office.create');
    }

    /**
     * Store a newly created Front Office account.
     */
    public function store(StoreFrontOfficeRequest $request): RedirectResponse|JsonResponse
    {
        Gate::authorize('create', [User::class, 'fo']);

        $validated = $request->validated();
        $validated['role'] = UserRole::Fo;
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'create_front_office',
            'description' => "Created Front Office account: {$user->email}",
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Front Office created successfully.', 'data' => $user], 201);
        }

        return redirect()->route('front-offices.index')->with('success', 'Front Office account created successfully.');
    }

    /**
     * Display the specified Front Office account.
     */
    public function show(User $user, Request $request): View|JsonResponse
    {
        Gate::authorize('view', $user);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $user]);
        }

        return view('front_office.show', compact('user'));
    }

    /**
     * Show the form for editing the specified Front Office account.
     */
    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        return view('front_office.edit', compact('user'));
    }

    /**
     * Update the specified Front Office account.
     */
    public function update(UpdateFrontOfficeRequest $request, User $user): RedirectResponse|JsonResponse
    {
        Gate::authorize('update', $user);

        $validated = $request->validated();

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'update_front_office',
            'description' => "Updated Front Office account: {$user->email}",
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Front Office updated successfully.', 'data' => $user]);
        }

        return redirect()->route('front-offices.index')->with('success', 'Front Office account updated successfully.');
    }

    /**
     * Remove the specified Front Office account from storage.
     */
    public function destroy(User $user, Request $request): RedirectResponse|JsonResponse
    {
        Gate::authorize('delete', $user);

        $email = $user->email;
        $user->delete();

        ActivityLog::create([
            'user_id' => $request->user()?->id,
            'activity' => 'delete_front_office',
            'description' => "Deleted Front Office account: {$email}",
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Front Office deleted successfully.']);
        }

        return redirect()->route('front-offices.index')->with('success', 'Front Office account deleted successfully.');
    }
}
