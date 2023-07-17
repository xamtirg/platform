<?php

namespace Xamtirg\Table\Http\Requests;

use Xamtirg\Support\Http\Requests\Request;

class BulkChangeRequest extends Request
{
    public function rules(): array
    {
        return [
            'class' => 'required',
        ];
    }
}
