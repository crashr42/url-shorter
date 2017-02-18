<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 3:53 PM
 */

namespace UrlShorter\Libs;

/**
 * Get value by key or default value if key not exists.
 *
 * @param array $arr
 * @param string|int $key
 * @param mixed $default
 * @return mixed
 */
function array_get($arr, $key, $default = null)
{
    if (!is_array($arr)) {
        return null;
    }

    if (array_key_exists($key, $arr)) {
        return $arr[$key];
    }

    return value($default);
}

/**
 * Get value or invoke callable.
 *
 * @param mixed $value
 * @return mixed
 */
function value($value)
{
    return is_callable($value) ? $value() : $value;
}

/**
 * Print debug and stop application.
 */
function dd()
{
    /** @noinspection ForgottenDebugOutputInspection */
    var_dump(func_get_args());
    exit;
}

/**
 * Convert given value to null.
 *
 * @param mixed $value
 * @return null|mixed
 */
function nullify($value)
{
    if (is_string($value) && trim($value) === '') {
        return null;
    }

    return $value;
}

/**
 * Check string starts with prefix.
 *
 * @param string $value
 * @param string $prefix
 * @return bool
 */
function starts_with($value, $prefix)
{
    return strpos($value, $prefix) === 0;
}
