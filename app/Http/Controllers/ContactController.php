<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPostStore;
use App\Http\Requests\ContactPutStore;
use App\Http\Traits\ApiResponser;
use App\Jobs\ContactCreateJob;
use App\Jobs\ContactUpdateJob;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
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
        $list = Cache::rememberForever('contact_page_'.$request->get('page').'_limit_'.$request->get('limit'), function () use ($request) {
            return Contact::with([
                'phones',
                'locations.city.country',
                'emails'
            ])
                ->skip($request->input('page') * $request->input('limit'))
                ->take($request->input('limit'))
                ->orderBy('id', 'desc')
                ->get();
        });
        $this->setData($list);
        return $this->apiResponse();
    }

    public function store(ContactPostStore $request): JsonResponse
    {

        $this->addLog('Started store function');
        $validate = $request->validated();
        $this->addLog('Parameters validated');

        ContactCreateJob::dispatch($validate);

        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }

    public function update(ContactPutStore $request, $id): JsonResponse
    {
        $this->addLog('Started update function');
        $validate = $request->validated();
        $this->addLog('Parameters validated');

        $db_parameters = array_filter($validate, function ($key) {
            return Schema::hasColumn('contacts', $key);
        }, ARRAY_FILTER_USE_KEY);

        $db_parameters['id'] = $id;
        ContactUpdateJob::dispatch($db_parameters);

        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }

    public function destroy($id, Request $request): JsonResponse
    {
        $this->addLog('Started destroy function');

        $contact = Contact::find($id);
        if ($contact) $contact->delete();
        else $this->addLog('ID invalid');

        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }
}
