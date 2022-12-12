<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactPostStore extends FormRequest
{
    use ApiResponser;


    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'company_id' => 'integer|exists:companies,id',
            'photo' => 'regex:([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)',
            "information_type" => "required|string|exists:information_types,name",
            "information_content" => "required",
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $validator = parent::getValidatorInstance();
        $validator
            ->sometimes('information_content', 'email|unique:mail_addresses,email', function ($input) {
                return $input->information_type === 'email';
            })
            ->sometimes('information_content', 'integer|digits:10|unique:phone_numbers,phone', function ($input) {
                return $input->information_type === 'phone';
            })
            ->sometimes('information_content', 'integer|exists:cities,id', function ($input) {
                return $input->information_type === 'location';
            });
        return $validator;
    }

    protected function failedValidation(Validator $validator)
    {
        $this->addMessage($validator->errors());
        $this->setFailedParameters($validator->failed());
        $this->setStatusCode(422);
        throw new HttpResponseException($this->apiResponse());
    }
}
