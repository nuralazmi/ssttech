<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationPostStore;
use App\Http\Traits\ApiResponser;
use App\Jobs\AddLocationJob;
use App\Jobs\AddMailAddressJob;
use App\Jobs\AddPhoneNumberJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    use ApiResponser;

    public function add(InformationPostStore $request): JsonResponse
    {
        $this->addLog('Started add function');
        $validate = $request->validated();
        $this->addLog('Parameters validated');

        $information_type = $validate['information_type'];
        if ($information_type === 'phone')
            AddPhoneNumberJob::dispatch($validate);
        elseif ($information_type === 'email')
            AddMailAddressJob::dispatch($validate);
        else
            AddLocationJob::dispatch($validate);

        $this->addLog('Function ended');

        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }
}
