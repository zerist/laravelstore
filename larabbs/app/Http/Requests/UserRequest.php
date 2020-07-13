<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
        return [
            'name' => ['required', 'between:3,25', 'regex:/^[A-Za-z0-9\-\_]+$/', 'unique:users,name,' . Auth::id()],
            'email' => ['required', 'email'],
            'introduction' => 'max:80',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Name existed!',
            'name.regex' => 'Name must with Alpha, Number, - or _!',
            'name.between' => 'Name Length must in 3-25 chars!',
            'name.required' => 'Name cannt be null!'
        ];
    }
}
