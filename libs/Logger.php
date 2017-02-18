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
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function debug($message)
    {
        $message = sprintf("%s: %s\n", date('Y-m-d H:i:s'), $message);

        file_put_contents($this->file, $message, FILE_APPEND);
    }
}
