<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 5:00 PM
 */

namespace UrlShorter;

use UrlShorter\Libs\Random;

class UrlHasher
{
    public static function hash($url)
    {
        return bin2hex(Random::bytes(3));
    }

    public static function filter($hash)
    {
        return trim(preg_replace('/[^a-zA-Z0-9]+/', '', $hash));
    }

    public static function hashIsValid($hash)
    {
        return strlen(static::filter($hash)) === 6;
    }

    public static function urlIsValid($url)
    {
        return is_string($url) && strlen($url) <= 2000;
    }
}
