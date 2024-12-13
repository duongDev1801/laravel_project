<?php


namespace Modules\Category\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'parent_id' => 'required|integer',
        ];

        return $rules;
    }
    public function messages()
    {
        return [
            'required' => config('category.validation.messages.required'),
            'max' => config('category.validation.messages.max'),
            'interger' => config('category.validation.messages.interger')
        ];
    }

    public function attributes()
    {
        return [
            'name' => config('category.validation.attributes.name'),
            'slug' => config('category.validation.attributes.slug'),
            'parent_id' => config('category.validation.attributes.parent_id')
        ];
    }
}
