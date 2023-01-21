<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
                    'name' => ['required', 'unique:suppliers'],
                    'category_id' => 'nullable',
                    'website' => 'nullable',
                    'address' => 'nullable',
                    'city' => 'nullable',
                    'district' => 'nullable',
                    'country' => 'nullable',
                    'account_title' => 'nullable',
                    'bank_name' => 'nullable',
                    'branch_code' => 'nullable',
                    'account_number' => 'nullable',
                ];
                break;
            case 'PUT':
                return [
                    'name' => ['required', 'unique:suppliers,name,'.$this->id.',id'],
                    'category_id' => 'nullable',
                    'website' => 'nullable',
                    'address' => 'nullable',
                    'city' => 'nullable',
                    'district' => 'nullable',
                    'country' => 'nullable',
                    'account_title' => 'nullable',
                    'bank_name' => 'nullable',
                    'branch_code' => 'nullable',
                    'account_number' => 'nullable',
                ];
                break;   
        }
    }
}
