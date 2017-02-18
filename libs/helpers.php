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

function dd()
{
    var_dump(func_get_args());
    exit;
}
