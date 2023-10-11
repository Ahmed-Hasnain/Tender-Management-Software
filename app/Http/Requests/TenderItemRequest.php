<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenderItemRequest extends FormRequest
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
                    'item_id' => 'required',
                    'unit_id' => 'required',
                    'qty' => 'required',
                    'description' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'item_id' => 'required',
                    'unit_id' => 'required',
                    'qty' => 'required',
                    'description' => 'nullable',
                ];
                break;   
        }
    }

    public function messages() {
        return [
            'item_id.required' => 'Item field is required',
            'unit_id.required' => 'Unit field is required',
            'qty.required' => 'Quantity field is required',
        ];
    }
}
