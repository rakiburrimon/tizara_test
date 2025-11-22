<?php

namespace App\Http\Requests\Survey\SurveyQuestion;

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
            'questions' => 'required|array',
            'questions.*.survey_id' => 'required|exists:surveys,id',
            'questions.*.page_id' => 'nullable|exists:survey_pages,id',
            'questions.*.serial_number' => 'nullable|integer',
            'questions.*.question_text' => 'nullable|string|max:1000',
            'questions.*.question_type' => 'nullable|string',
            'questions.*.options' => 'nullable|array',
            'questions.*.options.*' => 'nullable|string|max:255',
            'questions.*.is_required' => 'boolean',
            'questions.*.conditional_parent_id' => 'nullable|exists:survey_questions,id',
            'questions.*.conditional_value' => 'nullable|string|max:100',
            'questions.*.conditional_operator' => 'nullable|string|max:10',
        ];
    }
}
