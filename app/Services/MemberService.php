<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberService
{
    /**
     * Get paginated members list with search, filter, and sort support.
     */
    public function getMembers(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = MemberProfile::with(['user', 'province', 'city', 'district', 'village', 'creator']);

        // Search
        if (! empty($filters['search'])) {
            $search = (string) $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('member_number', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filtering
        if (! empty($filters['province_id'])) {
            $query->where('province_id', $filters['province_id']);
        }

        if (! empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        if (! empty($filters['district_id'])) {
            $query->where('district_id', $filters['district_id']);
        }

        if (! empty($filters['village_id'])) {
            $query->where('village_id', $filters['village_id']);
        }

        if (! empty($filters['register_date'])) {
            $query->whereDate('register_date', $filters['register_date']);
        }

        // Sorting
        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDirection = strtolower($filters['sort_dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

        $allowedSorts = ['created_at', 'register_date', 'member_number', 'nik'];
        if (in_array($sortField, $allowedSorts, true)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Generate automatic member number.
     */
    public function generateMemberNumber(): string
    {
        do {
            $number = 'MBR-' . date('Ym') . '-' . Str::padLeft((string) random_int(1, 99999), 5, '0');
        } while (MemberProfile::where('member_number', $number)->exists());

        return $number;
    }

    /**
     * Create member profile and user in transaction.
     */
    public function createMember(array $data, int $createdByUserId): MemberProfile
    {
        return DB::transaction(function () use ($data, $createdByUserId) {
            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => UserRole::Member,
                'status' => UserStatus::Active,
            ]);

            // Handle avatar
            $avatarPath = null;
            if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
                $avatarPath = $data['avatar']->store('avatars', 'public');
            }

            // Generate member number if not passed
            $memberNumber = $data['member_number'] ?? $this->generateMemberNumber();

            // Create MemberProfile
            return MemberProfile::create([
                'user_id' => $user->id,
                'member_number' => $memberNumber,
                'nik' => $data['nik'],
                'avatar' => $avatarPath,
                'gender' => $data['gender'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'address' => $data['address'],
                'province_id' => $data['province_id'],
                'city_id' => $data['city_id'],
                'district_id' => $data['district_id'],
                'village_id' => $data['village_id'],
                'occupation' => $data['occupation'],
                'register_date' => $data['register_date'] ?? now()->format('Y-m-d'),
                'created_by' => $createdByUserId,
            ]);
        });
    }

    /**
     * Update member profile and user in transaction.
     */
    public function updateMember(MemberProfile $profile, array $data): MemberProfile
    {
        return DB::transaction(function () use ($profile, $data) {
            $user = $profile->user;

            $userData = [
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'phone' => $data['phone'] ?? $user->phone,
            ];

            if (! empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $user->update($userData);

            // Handle Avatar Upload & Replacement
            if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
                if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
                    Storage::disk('public')->delete($profile->avatar);
                }
                $data['avatar'] = $data['avatar']->store('avatars', 'public');
            } else {
                unset($data['avatar']);
            }

            $profile->update($data);

            return $profile->fresh(['user', 'province', 'city', 'district', 'village', 'creator']);
        });
    }

    /**
     * Soft delete member profile and associated user in transaction.
     */
    public function deleteMember(MemberProfile $profile): bool
    {
        return DB::transaction(function () use ($profile) {
            if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $user = $profile->user;
            $profileDeleted = $profile->delete();
            $userDeleted = $user ? $user->delete() : true;

            return $profileDeleted && $userDeleted;
        });
    }
}
