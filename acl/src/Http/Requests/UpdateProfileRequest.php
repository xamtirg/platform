<?php

namespace Xamtirg\ACL\Http\Requests;

use Xamtirg\Support\Http\Requests\Request;

class UpdateProfileRequest extends Request
{
    public function rules(): array
    {
        return [
            'username' => 'required|max:30|min:4',
            'first_name' => 'required|max:60|min:2',
            'last_name' => 'required|max:60|min:2',
            'email' => 'required|max:60|min:6|email',
        ];
    }
}
