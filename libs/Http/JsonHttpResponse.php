<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 7:43 PM
 */

namespace UrlShorter\Libs\Http;

class JsonHttpResponse extends HttpResponse
{
    public function getBody()
    {
        return json_encode(parent::getBody(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function getHeaders()
    {
        $headers                 = parent::getHeaders();
        $headers['Content-Type'] = 'application/json';

        return $headers;
    }
}
