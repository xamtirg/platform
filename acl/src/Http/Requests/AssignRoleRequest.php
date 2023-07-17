<?php

namespace Xamtirg\ACL\Http\Requests;

use Xamtirg\Support\Http\Requests\Request;

class AssignRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'pk' => 'required|integer|min:1',
            'value' => 'required|integer|min:1',
        ];
    }
}
