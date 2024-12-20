<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFollowerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'addressLine1' => ['required', 'string', 'max:100'],
            'addressLine2' => ['required', 'string', 'max:100'],
            'addressLine3' => ['required', 'string', 'max:100'],
            'district' => ['required', 'not_in:0'],
            'mobile1' => ['required', 'string', 'max:10', 'unique:contact_infos,mobile1','unique:contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],
            'mobile2' => ['nullable', 'string', 'max:10', 'unique:contact_infos,mobile1','unique:contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],
            'race' => ['required', 'not_in:0'],
            'religion' => ['required', 'not_in:0'],
            'civilStatus' => ['required', 'not_in:0'],
            'monastery' => ['required', 'not_in:0'],
            'nic' => ['required', 'unique:followers,nic', 'regex:/^([0-9]{9}[Vv]|[0-9]{12})$/'],
            'email' => ['nullable', 'unique:followers,email', 'email'],
            'birthDay' => ['required', 'date', 'before:today'],
        ];
    }
}
