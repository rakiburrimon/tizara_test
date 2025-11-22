<?php

namespace App\Http\Requests\Survey\SurveyQuestion;

use App\Http\Requests\BaseFormRequest;

class UpdateMultipleRequest extends BaseFormRequest
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
            'questions.*.id' => 'required|exists:survey_questions,id',
            'questions.*.survey_id' => 'required|exists:surveys,id',
            'questions.*.serial_number' => 'sometimes|nullable|integer',
            'questions.*.question_text' => 'sometimes|nullable|string|max:1000',
            'questions.*.question_type' => 'sometimes|nullable|string',
            'questions.*.options' => 'sometimes|nullable|array',
            'questions.*.options.*' => 'sometimes|nullable|string|max:255',
            'questions.*.is_required' => 'sometimes|boolean',
            'questions.*.conditional_parent_id' => 'sometimes|nullable|exists:survey_questions,id',
            'questions.*.conditional_value' => 'sometimes|nullable|string|max:100',
            'questions.*.conditional_operator' => 'sometimes|nullable|string|max:10',
        ];
    }
}
