<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponser;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    use ApiResponser;

    public function index(Request $request): JsonResponse
    {
        if ($request->has('debug')) $this->setDebug(true);
        $this->addLog('Started index function');
        $validate = Validator::make($request->all(), [
            'page' => 'required|integer',
            'limit' => 'required|integer',
        ]);
        if ($validate->fails()) {
            $this->addLog('No validated');
            $this->addMessage($validate->messages());
            $this->setFailedParameters($validate->failed());
            $this->setStatusCode(400);
            return $this->apiResponse();
        }
        $this->addLog('Parameters validated');
        $list = Contact::with([
            'phones',
            'locations.city.country',
            'emails'
        ])
            ->skip($request->input('page') * $request->input('limit'))
            ->take($request->input('limit'))
            ->orderBy('id','desc')
            ->get();

        $this->setData($list);
        return $this->apiResponse();
    }

}
