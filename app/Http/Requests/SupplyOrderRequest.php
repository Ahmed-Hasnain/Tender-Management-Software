<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplyOrderRequest extends FormRequest
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
                    'date_of_supply_order' => 'required',
                    'delivery_date' => 'required',
                    'status' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'date_of_supply_order' => 'required',
                    'delivery_date' => 'required',
                    'status' => 'required',
                ];
                break;   
        }
    }
}
