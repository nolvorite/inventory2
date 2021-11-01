<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequestU extends FormRequest
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
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assigned_by_id' => ['nullable'],
            'assigned_to_id' => ['nullable'],
            'product_id' => ['nullable'],
            'quantity' => ['nullable','integer'],
            'quantity_sold' => ['nullable','integer'],
            'notes' => ['nullable'],
            'return_status' => ['nullable'],
            'returned_amount' => ['nullable', 'integer']
        ];
    }
}
