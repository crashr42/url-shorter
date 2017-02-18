<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:14 PM
 */

namespace UrlShorter\Libs;

use UrlShorter\App;
use UrlShorter\Libs\Http\HttpRequest;

class AppRequest
{
    /**
     * @var HttpRequest
     */
    private $httpRequest;
    /**
     * @var App
     */
    private $app;

    /**
     * AppRequest constructor.
     * @param App $app
     * @param HttpRequest $httpRequest
     */
    public function __construct(App $app, HttpRequest $httpRequest)
    {
        $this->app         = $app;
        $this->httpRequest = $httpRequest;
    }

    /**
     * Get controller action name.
     *
     * @return string
     */
    public function actionName()
    {
        $urlPath = $this->httpRequest->urlPath();

        if (($slashPos = strpos($urlPath, '/', 1)) !== false) {
            $urlPath = substr($urlPath, 0, $slashPos);
        }

        $actionName = trim(preg_replace('/[^a-zA-Z0-9]+/', '', $urlPath));

        return $actionName === '' ? 'root' : $actionName;
    }
}
