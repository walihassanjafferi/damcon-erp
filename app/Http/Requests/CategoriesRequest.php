<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'module_id' => 'required',
            'category_name' => 'required|max:30'
        ];
    }

    public function messages()
    {
        return [
            'module_id.required' => 'Module is a required field',
            'category_name.required' => 'Name is a required field'
        ];
    }
}
 