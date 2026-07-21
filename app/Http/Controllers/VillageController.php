<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Village;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of villages (optional filtering by district_id).
     */
    public function index(Request $request): View|JsonResponse
    {
        $districtId = $request->integer('district_id');

        if ($districtId > 0) {
            $villages = $this->locationService->getVillagesByDistrict($districtId);
        } else {
            $villages = Village::with('district')->orderBy('name', 'asc')->get();
        }

        if ($request->wantsJson() || $request->expectsJson() || $request->ajax() || $districtId > 0) {
            return response()->json(['success' => true, 'data' => $villages]);
        }

        return view('villages.index', compact('villages'));
    }
}
