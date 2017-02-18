<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 5:21 PM
 */

namespace UrlShorter\Libs\Http;

class HttpResponse
{
    /**
     * @var string
     */
    private $body;
    /**
     * @var int
     */
    private $code;

    /**
     * @var array
     */
    private $headers;

    public function __construct($body = '', $code = 200, array $headers = [])
    {
        $this->body    = $body;
        $this->code    = $code;
        $this->headers = $headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
