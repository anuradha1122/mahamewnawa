<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'mobile1' => ['required', 'string', 'max:10', 'unique:user_contact_infos,mobile1','unique:user_contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],
            'mobile2' => ['required', 'string', 'max:10', 'unique:user_contact_infos,mobile1','unique:user_contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],
            'race' => ['required', 'not_in:0'],
            'religion' => ['required', 'not_in:0'],
            'civilStatus' => ['required', 'not_in:0'],
            'monastery' => ['required', 'not_in:0'],
            'category' => ['required', 'not_in:0'],
            'position' => ['required', 'not_in:0'],
            'nic' => ['required', 'unique:users,nic', 'regex:/^([0-9]{9}[Vv]|[0-9]{12})$/'],
            'email' => ['required', 'unique:users,email', 'email'],
            'birthDay' => ['required', 'date', 'before:today'],
            'startDate' => ['required', 'date','after_or_equal:birthDay'],
        ];
    }
}
