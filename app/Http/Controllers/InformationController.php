<?php

namespace App\Http\Controllers;

use App\Http\Requests\InformationPostStore;
use App\Http\Requests\InformationRemoveStore;
use App\Http\Traits\ApiResponser;
use App\Jobs\AddLocationJob;
use App\Jobs\AddMailAddressJob;
use App\Jobs\AddPhoneNumberJob;
use App\Models\Location;
use App\Models\MailAddress;
use App\Models\PhoneNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        Cache::flush();
        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }

    public function remove(InformationRemoveStore $request, $contact_id): JsonResponse
    {
        $this->addLog('Started remove function');
        $validate = $request->validated();
        $this->addLog('Parameters validated');

        $information_type = $validate['information_type'];
        $information_content = $validate['information_content'];
        if ($information_type === 'email')
            MailAddress::where('contact_id', $contact_id)->where('email', $information_content)->delete();
        elseif ($information_type === 'phone')
            PhoneNumber::where('contact_id', $contact_id)->where('phone', $information_content)->delete();
        else
            Location::where('contact_id', $contact_id)->where('city_id', $information_content)->delete();

        $this->addLog('Function ended');

        if ($request->has('debug')) $this->setDebug(true);
        return $this->apiResponse();
    }
}
