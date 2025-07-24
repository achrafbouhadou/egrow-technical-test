<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\IssuesStatus;
use App\Enums\IssuesPriority;

class IssueFilterRequest extends FormRequest
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
          'status' => [
                'sometimes',
                'string',
                Rule::in(IssuesStatus::values())
            ],
            'priority' => [
                'sometimes',
                'string',
                Rule::in(IssuesPriority::values())
            ],
            'assigned_to' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'project_id' => [
                'sometimes',
                'integer',
                'exists:projects,id'
            ],
            'page' => [
                'sometimes',
                'integer',
                'min:1'
            ],
        ];
    }
}
