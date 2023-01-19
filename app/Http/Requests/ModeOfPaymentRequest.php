<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModeOfPaymentRequest extends FormRequest
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
                    'name' => ['required', 'unique:mode_of_payments'],
                ];
                break;
            case 'PUT':
                return [
                    'name' => ['required', 'unique:mode_of_payments,name,'.$this->id.',id'],
                ];
                break;   
        }
    }
}
