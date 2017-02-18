<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:59 PM
 */

namespace UrlShorter\Libs;

class Random
{
    public static function bytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}
