<?php

namespace App\Http\Requests\Survey\SurveyPage;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
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
            'serial_number' => 'sometimes|nullable|integer',
            'title' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
        ];
    }
}
