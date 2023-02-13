<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
                    'name' => ['required', 'unique:currencies'],
                    'symbol' => ['required', 'unique:currencies'],
                ];
                break;
            case 'PUT':
                return [
                    'name' => ['required', 'unique:currencies,name,'.$this->id.',id'],
                    'symbol' => ['required', 'unique:currencies,symbol,'.$this->id.',id'],
                ];
                break;   
        }
    }
}
