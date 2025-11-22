<?php

namespace App\Http\Requests\Survey\Survey;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'open_datetime' => 'nullable|date',
            'close_datetime' => 'nullable|date|after_or_equal:open_datetime',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'creator_id' => auth()->id(),
            'join_link' => generate_survey_join_link(),
        ]);
    }

    /**
     * Get the validated data with the added user_id.
     */
    public function validated($key = null, $default = null)
    {
        return array_merge(parent::validated(), [
            'creator_id' => auth()->id(),
            'join_link' => generate_survey_join_link(),
        ]);
    }
}
