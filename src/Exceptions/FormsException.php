<?php

namespace Tatter\Forms\Exceptions;

use CodeIgniter\Exceptions\ExceptionInterface;
use CodeIgniter\Exceptions\FrameworkException;

class FormsException extends FrameworkException implements ExceptionInterface
{
    public static function forInvalidConfigItem(string $route)
    {
        return new static(lang('Forms.invalidConfigItem', [$route]));
    }

    public static function forMissingModel(string $class)
    {
        return new static(lang('Forms.missingModel', [$class]));
    }
}
