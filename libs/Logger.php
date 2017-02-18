<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 7:25 PM
 */

namespace UrlShorter\Libs;

class Logger
{
    public static function debug($message)
    {
        $message = sprintf("%s: %s\n", date('Y-m-d H:i:s'), $message);

        file_put_contents(__DIR__.'/../logs/debug.log', $message, FILE_APPEND);
    }
}
