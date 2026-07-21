<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProvinceController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of provinces.
     */
    public function index(Request $request): View|JsonResponse
    {
        $provinces = $this->locationService->getProvinces();

        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'data' => $provinces]);
        }

        return view('provinces.index', compact('provinces'));
    }
}
