<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRecievingRequest extends FormRequest
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
                    'supply_order_id' => ['required', 'exists:supply_orders,id'],
                    'cheque_no' => ['required'],
                    'bank_name' => ['required'],
                    'cheque_amount' => ['required', 'numeric'],
                    'income_tax_amount' => ['required', 'numeric'],
                    'gst_withhold_amount' => ['required', 'numeric'],
                    'payment_date' => ['required', 'date'],
                    'cheque_date' => ['required', 'date'],
                    'serial_no' => ['required'],
                    'status' => ['required'],
                ];
                break;
            case 'PUT':
                return [
                    'supply_order_id' => ['required', 'exists:supply_orders,id'],
                    'cheque_no' => ['required'],
                    'bank_name' => ['required'],
                    'cheque_amount' => ['required', 'numeric'],
                    'income_tax_amount' => ['required', 'numeric'],
                    'gst_withhold_amount' => ['required', 'numeric'],
                    'payment_date' => ['required', 'date'],
                    'cheque_date' => ['required', 'date'],
                    'serial_no' => ['required'],
                    'status' => ['required'],
                ];
                break;   
        }
    }
}
