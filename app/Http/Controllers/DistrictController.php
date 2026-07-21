<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\District;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of districts (optional filtering by city_id).
     */
    public function index(Request $request): View|JsonResponse
    {
        $cityId = $request->integer('city_id');

        if ($cityId > 0) {
            $districts = $this->locationService->getDistrictsByCity($cityId);
        } else {
            $districts = District::with('city')->orderBy('name', 'asc')->get();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $districts]);
        }

        return view('districts.index', compact('districts'));
    }
}
