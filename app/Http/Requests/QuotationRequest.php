<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
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
                    'reference_no' => ['required', 'unique:quotations'],
                    'currency' => 'required',
                    'terms_and_conditions' => 'nullable',
                    'delivery_time' => 'required',
                    'validity_of_quotation' => 'required',
                    'status' => 'required',
                    'tax' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'reference_no' => ['required', 'unique:quotations,reference_no,'.$this->id.',id'],
                    'currency' => 'required',
                    'terms_and_conditions' => 'nullable',
                    'delivery_time' => 'required',
                    'validity_of_quotation' => 'required',
                    'status' => 'required',
                    'tax' => 'nullable',
                ];
                break;   
        }
    }
}
