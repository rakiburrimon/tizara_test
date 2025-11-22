<?php

namespace App\Http\Requests\Survey\SurveyQuestion;

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
            'page_id' => 'nullable|exists:survey_pages,id',
            'serial_number' => 'nullable|integer',
            'question_text' => 'nullable|string|max:1000',
            'question_type' => 'nullable|string',
            'options' => 'nullable|array',
            'options.*' => 'nullable|string|max:255',
            'is_required' => 'boolean',
            'conditional_parent_id' => 'nullable|exists:survey_questions,id',
            'conditional_value' => 'nullable|string|max:100',
            'conditional_operator' => 'nullable|string|max:10',
        ];
    }
}
