<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
            'user_id' => ['nullable', 'integer', Rule::exists('users', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:75'],
            'phone' => ['nullable', 'string', 'max:50'],
            'reference' => ['required', 'string', 'max:50', 'unique:clients,reference'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
