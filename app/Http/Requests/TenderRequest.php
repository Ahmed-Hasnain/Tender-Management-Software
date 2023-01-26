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
                    'file_name' => 'nullable',
                    'rate_basis' => 'nullable',
                    'delivery_time' => 'nullable',
                    'description' => 'nullable',
                    'special_terms' => 'nullable',
                    'rfq_date' => 'nullable|date',
                    'last_date_of_submission' => 'nullable|date',
                    'validity_of_quotation' => 'nullable|date',
                    'client_id ' => 'nullable',
                    'mode_of_payment_id ' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'reference_no' => ['required', 'unique:tenders,reference_no,'.$this->id.',id'],
                    'file_name' => 'nullable',
                    'rate_basis' => 'nullable',
                    'delivery_time' => 'nullable',
                    'description' => 'nullable',
                    'special_terms' => 'nullable',
                    'rfq_date' => 'nullable|date',
                    'last_date_of_submission' => 'nullable|date',
                    'validity_of_quotation' => 'nullable|date',
                    'client_id ' => 'nullable',
                    'mode_of_payment_id ' => 'nullable',
                ];
                break;   
        }
    }
}
