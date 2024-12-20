<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDambadiwaProjectRequest extends FormRequest
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
        return $rules = [
            'name' => ['required', 'unique:dambadiwa_projects,name', 'string', 'max:100'],
            'startDate' => ['required', 'date', 'after:today'],
            'endDate' => ['required', 'date', 'after:startDay'],
        ];
    }
}
