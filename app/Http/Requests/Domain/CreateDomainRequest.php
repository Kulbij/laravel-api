<?php

namespace App\Http\Requests\Domain;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateDomainRequest
 *
 * @package App\Http\Requests
 */
class CreateDomainRequest extends FormRequest
{
    /**
     * Determine if the employee is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'target_domains' => 'required',
            'excluded_targets',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'target_domains.required' => 'Required domain field.',
        ];
    }
}
