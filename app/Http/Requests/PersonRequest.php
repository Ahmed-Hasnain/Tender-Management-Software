<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
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
                    'name' => ['required'],
                    'email' => 'nullable',
                    'phone_no' => 'nullable',
                    'mobile_no' => 'nullable',
                    'department' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'name' => ['required'],
                    'email' => 'nullable',
                    'phone_no' => 'nullable',
                    'mobile_no' => 'nullable',
                    'department' => 'nullable',
                ];
                break;   
        }
    }
}
