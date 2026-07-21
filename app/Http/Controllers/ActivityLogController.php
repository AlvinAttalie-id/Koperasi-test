<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs.
     */
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        $query = ActivityLog::with('user');

        if ($user->role !== UserRole::SuperAdmin) {
            $query->where('user_id', $user->id);
        }

        $logs = $query->latest('created_at')->paginate(10);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $logs]);
        }

        return view('activity_logs.index', compact('logs'));
    }
}
