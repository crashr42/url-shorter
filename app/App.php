<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 3:42 PM
 */

namespace UrlShorter;

use Exception;
use UrlShorter\Libs\AppRequest;
use UrlShorter\Libs\Http\HttpException;
use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\Libs\Http\HttpResponse;

class App
{
    const FALLBACK_ACTION = 'root';

    /**
     * @var LongUrlController
     */
    private $controller;

    /**
     * App constructor.
     * @param LongUrlController $controller
     */
    public function __construct(LongUrlController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Dispatch HTTP request.
     *
     * @param HttpRequest $httpRequest
     * @throws \RuntimeException
     */
    public function dispatch(HttpRequest $httpRequest)
    {
        $appRequest = $this->makeAppRequest($httpRequest);

        $actionName = $appRequest->actionName();

        ob_start();
        try {
            if (!method_exists($this->controller, $actionName)) {
                if (!method_exists($this->controller, static::FALLBACK_ACTION)) {
                    throw new HttpException(404);
                }

                $actionName = static::FALLBACK_ACTION;
            }

            /** @noinspection VariableFunctionsUsageInspection */
            $out = call_user_func([$this->controller, $actionName], $httpRequest);

            ob_get_clean();

            if ($out instanceof HttpResponse) {
                http_response_code($out->getCode());

                foreach ($out->getHeaders() as $key => $value) {
                    header(sprintf('%s: %s', $key, $value));
                }
                header(sprintf('Content-Length: %d', strlen($out->getBody())));

                echo $out->getBody();
            } else {
                http_response_code(200);

                echo $out;
            }
        } catch (HttpException $e) {
            ob_get_clean();

            header(sprintf('HTTP/1.0 %d %s', $e->getCode(), $e->getMessage()));
        } catch (Exception $e) {
            ob_get_clean();

            header(sprintf('HTTP/1.0 %d %s', $e->getCode(), $e->getMessage()));
        }
    }

    /**
     * Create internal app request.
     *
     * @param HttpRequest $httpRequest
     * @return AppRequest
     */
    public function makeAppRequest(HttpRequest $httpRequest)
    {
        return new AppRequest($this, $httpRequest);
    }
}
