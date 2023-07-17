<?php

namespace Xamtirg\Setting\Http\Requests;

use Xamtirg\Support\Http\Requests\Request;

class SendTestEmailRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}
