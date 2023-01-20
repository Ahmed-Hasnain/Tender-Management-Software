<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
                    'full_name' => ['required', 'unique:units'],
                    'short_name' => ['required', 'unique:units'],
                ];
                break;
            case 'PUT':
                return [
                    'full_name' => ['required', 'unique:units,full_name,'.$this->id.',id'],
                    'short_name' => ['required', 'unique:units,short_name,'.$this->id.',id'],
                ];
                break;   
        }
    }
}
