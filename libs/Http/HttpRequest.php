<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 3:47 PM
 */

namespace UrlShorter\Libs\Http;

use UrlShorter\Libs\FileUtils;

class HttpRequest
{
    /**
     * @var array
     */
    private $server;

    /**
     * @var array
     */
    private $query;

    /**
     * Request constructor.
     * @param $server
     * @param $query
     */
    public function __construct(array $server = [], array $query = [])
    {
        $this->server = $server;
        $this->query  = $query;
    }

    /**
     * Get server value.
     *
     * @param null|string $key
     * @return array|string
     */
    public function server($key = null)
    {
        if ($key === null) {
            return $this->server;
        }

        return \UrlShorter\Libs\array_get($this->server, $key);
    }

    /**
     * Get GET param value.
     *
     * @param null|string $key
     * @return array|mixed
     */
    public function param($key = null)
    {
        if ($key === null) {
            return $this->query;
        }

        return \UrlShorter\Libs\array_get($this->query, $key);
    }

    /**
     * Get url path.
     *
     * @return string
     */
    public function urlPath()
    {
        return $this->server('SCRIPT_NAME');
    }

    /**
     * Get server host.
     *
     * @return string
     */
    public function serverHost()
    {
        $protocol = 'http';
        if (stripos($this->server['SERVER_PROTOCOL'], 'https') !== false) {
            $protocol = 'https';
        }

        return sprintf('%s://%s', $protocol, $this->server['HTTP_HOST']);
    }

    /**
     * Get current request uri.
     *
     * @return array|string
     */
    public function url()
    {
        return FileUtils::join($this->serverHost(), $this->server('REQUEST_URI'));
    }
}
