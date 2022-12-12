<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponser;

    public function getPeopleByLocation($city_id, Request $request): JsonResponse
    {
        $this->addLog('Started getPeopleByLocation function');
        $items = City::with('country')
            ->withCount([
                'locations as people_count' => function ($query) use ($city_id) {
                    $query->where('city_id', $city_id);
                }
            ])->find($city_id);
        if ($items !== null) $this->setData($items);

        $this->addLog('Function ended');
        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }
}
