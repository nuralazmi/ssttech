<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class InformationRemoveStore extends FormRequest
{
    use ApiResponser;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        request()->merge(['contact_id' => $this->contact_id]);
        return [
            'contact_id' => 'required|integer|exists:contacts,id',
            "information_type" => "required|string|exists:information_types,name",
            "information_content" => "required",
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $validator = parent::getValidatorInstance();
        $validator
            ->sometimes('information_content', [
                'integer',
                Rule::exists('locations', 'city_id')->where(
                    'contact_id', $this->contact_id
                )
            ], function ($input) {
                return $input->information_type === 'location';
            })
            ->sometimes('information_content', [
                'email',
                Rule::exists('mail_addresses', 'email')->where(
                    'contact_id', $this->contact_id
                )
            ], function ($input) {
                return $input->information_type === 'email';
            })
            ->sometimes('information_content', [
                'integer',
                'digits:10',
                Rule::exists('phone_numbers', 'phone')->where(
                    'contact_id', $this->contact_id
                )
            ], function ($input) {
                return $input->information_type === 'phone';
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
