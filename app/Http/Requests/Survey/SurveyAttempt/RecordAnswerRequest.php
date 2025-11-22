<?php

namespace App\Http\Requests\Survey\SurveyAttempt;

use App\Http\Requests\BaseFormRequest;

class RecordAnswerRequest extends BaseFormRequest
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
            'question_id' => 'required|exists:survey_questions,id',
            'answer_data' => 'nullable',
        ];
    }
}
