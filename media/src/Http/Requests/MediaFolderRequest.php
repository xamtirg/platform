<?php

namespace Xamtirg\Media\Http\Requests;

use Xamtirg\Support\Http\Requests\Request;

class MediaFolderRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[\pL\s\ \_\-0-9]+$/u',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => trans('core/media::media.name_invalid'),
        ];
    }
}
