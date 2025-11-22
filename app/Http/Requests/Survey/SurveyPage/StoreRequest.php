<?php

namespace App\Http\Requests\Survey\SurveyPage;

use App\Http\Requests\BaseFormRequest;

class StoreRequest extends BaseFormRequest
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
            'survey_id' => 'required|exists:surveys,id',
            'page_number' => 'nullable|integer',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
