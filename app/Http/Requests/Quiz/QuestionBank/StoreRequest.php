<?php

namespace App\Http\Requests\Quiz\QuestionBank;

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
            'name' => 'required|string|max:255',
            'question_bank_category_id' => 'required|integer|exists:question_bank_categories,id',
            'tags' => 'nullable|string|max:255',
        ];
    }
}
