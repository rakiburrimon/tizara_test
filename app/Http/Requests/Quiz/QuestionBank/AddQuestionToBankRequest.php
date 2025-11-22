<?php

namespace App\Http\Requests\Quiz\QuestionBank;

use App\Http\Requests\BaseFormRequest;

class AddQuestionToBankRequest extends BaseFormRequest
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
            'question_bank_id' => ['nullable', 'exists:question_banks,id'],
            'question_id' => ['required', 'exists:questions,id'],
        ];
    }
}
