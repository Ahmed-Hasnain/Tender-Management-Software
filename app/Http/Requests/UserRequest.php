<?php

namespace App\Http\Requests;

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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required',
                    'phone' => ['required'],
                    'email' => ['required', 'email' , 'unique:users'],
                    'user_type' => 'required',
                    'status' => 'required',
                    'about' => 'required',
                    'dob' => 'required',
                    'password' => 'required'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required',
                    'phone' => ['required'],
                    'email' => ['required', 'unique:users,email,'.$this->id.',id'],
                    'user_type' => 'required',
                    'status' => 'required',
                    'about' => 'required',
                    'dob' => 'required',
                    'password' => 'required'
                ];
                break;   
        }
    }
}
