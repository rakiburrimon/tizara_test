<?php

namespace App\Http\Requests\Survey\SurveyPage;

use App\Http\Requests\BaseFormRequest;

class StoreMultipleRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pages' => 'required|array',
            'pages.*.survey_id' => 'required|exists:surveys,id',
            'pages.*.page_number' => 'nullable|integer',
            'pages.*.title' => 'nullable|string|max:255',
            'pages.*.description' => 'nullable|string',
        ];
    }
}
