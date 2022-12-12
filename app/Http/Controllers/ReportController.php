<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    use ApiResponser;

    public function getPeopleByLocation($city_id, Request $request): JsonResponse
    {
        $this->addLog('Started getPeopleByLocation function');
        $items = Cache::rememberForever('report_people_'.$city_id, function () use ($city_id, $request) {
            return City::with('country')
                ->withCount([
                    'locations as people_count' => function ($query) use ($city_id) {
                        $query->where('city_id', $city_id);
                    }
                ])->find($city_id);
        });
        if ($items !== null) $this->setData($items);

        $this->addLog('Function ended');
        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }

    public function getPhonesByLocation($city_id, Request $request): JsonResponse
    {
        if ($request->has('debug')) $this->setDebug(true);
        $this->addLog('Started getPhonesByLocation function');

        $this->addLog('Validatate check');
        $validate = Validator::make(['city_id' => $city_id], [
            'city_id' => 'required|integer|exists:cities,id',
        ]);
        if ($validate->fails()) {
            $this->addLog('No validated');
            $this->addMessage($validate->messages());
            $this->setFailedParameters($validate->failed());
            $this->setStatusCode(400);
            return $this->apiResponse();
        }
        $item = Cache::rememberForever('report_people_'.$city_id, function () use ($city_id, $request) {
            return City::with([
                'locations.contact.phones',
                'country'
            ])->find($city_id);
        });
        $item->phones_count = 0;
        foreach ($item->locations as $location) {
            if (isset($location->contact->phones)) $item->phones_count += count($location->contact->phones);
            unset($item->locations);
        }
        $this->setData($item);

        $this->addLog('Function ended');
        return $this->apiResponse();
    }

}
