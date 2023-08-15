<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo'          => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'name'          => 'required|min:2|unique:companies,name',
            'email'         => 'required|email|unique:companies,email',
            'address'       => 'required|String|min:4',
            'website'       => 'required|url',
            'phone'         => 'required|regex:/^\+?[0-9]{1,3}[-. ]?\(?[0-9]{1,}\)?[-. ]?[0-9]{1,}[-. ]?[0-9]{1,}$/',
            'description'   => 'nullable',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
