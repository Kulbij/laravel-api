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
            'target_domains' => 'required|array',
            'target_domains.*' => [
                'required',
                'regex:/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i',
            ],
            
            'excluded_targets' => 'required',
            'excluded_targets.*' => [
                'required',
                'regex:/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i',
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'target_domains.required' => 'Required target domains field.',
            'excluded_targets.required' => 'Required excluded targets field.',
        ];
    }
}
