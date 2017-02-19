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
    const MAX_URL_LENGTH = 2000;

    public static function hash($url)
    {
        $out = shell_exec('dd if=/dev/urandom ibs=1 skip=0 count=3 status=none');
        if (\UrlShorter\Libs\nullify($out) === null || !static::hashIsValid(bin2hex($out))) {
            return bin2hex(Random::bytes(3));
        }

        return bin2hex($out);
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
        return is_string($url) && strlen($url) <= static::MAX_URL_LENGTH && strlen(trim($url)) > 0;
    }
}
