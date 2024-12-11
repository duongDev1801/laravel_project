<?php

namespace Modules\User\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->user->id;
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'group_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail(config('validation.custom.group'));
                    }
                }
            ],

        ];
        if ($id) {
            $rules['email'] = 'required|email|unique:users,email,' . $id;
            if (!$this->password) {
                unset($rules['password']);
            }
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'required' => config('validation.messages.required'),
            'email' => config('validation.messages.email'),
            'unique' => config('validation.messages.unique'),
            'min' => config('validation.messages.min'),
            'max' => config('validation.messages.max'),
            'interger' => config('validation.messages.interger')
        ];
    }

    public function attributes()
    {
        return [
            'name' => config('validation.attributes.name'),
            'email' => config('validation.attributes.email'),
            'password' => config('validation.attributes.password'),
            'group_id' => config('validation.attributes.group_id')
        ];
    }
}
