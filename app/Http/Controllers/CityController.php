<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of cities (optional filtering by province_id).
     */
    public function index(Request $request): View|JsonResponse
    {
        $provinceId = $request->integer('province_id');

        if ($provinceId > 0) {
            $cities = $this->locationService->getCitiesByProvince($provinceId);
        } else {
            $cities = City::with('province')->orderBy('name', 'asc')->get();
        }

        if ($request->wantsJson() || $request->expectsJson() || $request->ajax() || $provinceId > 0) {
            return response()->json(['success' => true, 'data' => $cities]);
        }

        return view('cities.index', compact('cities'));
    }
}
