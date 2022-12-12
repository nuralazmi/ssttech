<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactPutStore extends FormRequest
{
    use ApiResponser;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        request()->merge(['contact_id' => $this->contact]);
        return [
            'contact_id' => 'integer|exists:contacts,id',
            'name' => 'string',
            'last_name' => 'string',
            'company_id' => 'integer|exists:companies,id',
            'photo' => 'regex:([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->addMessage($validator->errors());
        $this->setFailedParameters($validator->failed());
        $this->setStatusCode(422);
        throw new HttpResponseException($this->apiResponse());
    }
}
