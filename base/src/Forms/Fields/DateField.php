<?php

namespace Xamtirg\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class DateField extends FormField
{
    protected function getTemplate(): string
    {
        return 'core/base::forms.fields.date-picker';
    }
}
