<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string'], //, new BetterEmail
            'password' => ['required', 'string'],
        ];
    }
}
