<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:44 PM
 */

namespace UrlShorter\Libs\Http;

use Exception;

class HttpException extends Exception
{
    const HTTP_CODES = [
        500 => 'Internal server error',
        422 => 'Unprocessable Entity',
        404 => 'Not found',
    ];

    public function __construct($code)
    {
        parent::__construct(\UrlShorter\Libs\array_get(static::HTTP_CODES, $code, ''), $code, null);
    }
}
