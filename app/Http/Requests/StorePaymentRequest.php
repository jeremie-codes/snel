<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->canManagePayments() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', Rule::exists('clients', 'id')->where('status', 'active')],
            'invoice_number' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999999999.99'],
            'currency' => ['required', Rule::in(['CDF', 'USD', 'EUR'])],
            'payment_method' => ['required', Rule::in(['cash', 'mobile_money', 'bank_transfer'])],
            'paid_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
