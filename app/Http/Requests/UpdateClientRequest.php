<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            //'user_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', 'client')],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:75'],
            'phone' => ['nullable', 'string', 'max:50'],
            'reference' => ['required', 'string', 'max:50', Rule::unique('clients', 'reference')->ignore($clientId)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
