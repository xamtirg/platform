<?php

namespace Xamtirg\Setting\Models;

use Xamtirg\Base\Models\BaseModel;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];
}
