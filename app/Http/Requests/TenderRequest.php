<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenderRequest extends FormRequest
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
                    'reference_no' => ['required', 'unique:tenders'],
                    'file_name' => 'required',
                    'rate_basis' => 'required',
                    'delivery_time' => 'nullable',
                    'description' => 'nullable',
                    'special_terms' => 'nullable',
                    'rfq_date' => 'required|date',
                    'last_date_of_submission' => 'required|date',
                    'validity_of_quotation' => 'nullable|date',
                    'client_id' => 'required',
                    'mode_of_payment_id' => 'required',
                    'company_id' => 'required',
                    'demand_id' => 'required',
                    'items.*.item_id' => 'required',
                    'items.*.unit_id' => 'required',
                    'items.*.qty' => 'required',
                    'items.*.description' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'reference_no' => ['required', 'unique:tenders,reference_no,'.$this->id.',id'],
                    'file_name' => 'required',
                    'rate_basis' => 'required',
                    'delivery_time' => 'nullable',
                    'description' => 'required',
                    'special_terms' => 'required',
                    'rfq_date' => 'required|date',
                    'last_date_of_submission' => 'required|date',
                    'validity_of_quotation' => 'nullable|date',
                    'client_id' => 'required',
                    'mode_of_payment_id' => 'required',
                    'company_id' => 'required',
                    'demand_id' => 'required',
                    'items.*.item_id' => 'required',
                    'items.*.unit_id' => 'required',
                    'items.*.qty' => 'required',
                    'items.*.description' => 'nullable',
                ];
                break;   
        }
    }

    public function messages() {
        return [
            'items.*.item_id.required' => 'Item field is required',
            'items.*.unit_id.required' => 'Unit field is required',
            'items.*.qty.required' => 'Quantity field is required',
        ];
    }
}
