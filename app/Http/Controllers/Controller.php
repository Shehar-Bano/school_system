<?php

namespace App\Http\Controllers;

abstract class Controller
{
    const DEFAULT_VALUE = 10;

    /**
     * Get pagination limit from request or return default value.
     *
     * @param  mixed  $value
     * @return int
     */
    public function getValue($value)
    {
        return (is_null($value) || !is_numeric($value) || (int) $value <= 0)
            ? self::DEFAULT_VALUE
            : (int) $value;
    }
}
