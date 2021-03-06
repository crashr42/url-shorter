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
use UrlShorter\Libs\ControllerInterface;
use UrlShorter\Libs\Http\HttpException;
use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\Libs\Http\HttpResponse;
use UrlShorter\Libs\Logger;

class App
{
    const FALLBACK_ACTION = 'root';

    /**
     * @var LongUrlController
     */
    private $controller;
    /**
     * @var string
     */
    private $root;
    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var array
     */
    private $config;

    /**
     * App constructor.
     * @param array $config
     * @param string $root
     * @param ControllerInterface $controller
     * @param Logger $logger
     */
    public function __construct($config, $root, ControllerInterface $controller, Logger $logger)
    {
        $this->root       = $root;
        $this->controller = $controller;
        $this->logger     = $logger;
        $this->config     = $config;

        if ($config['debug']) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
        }
    }

    /**
     * Dispatch HTTP request.
     *
     * @param HttpRequest $httpRequest
     * @throws \RuntimeException
     */
    public function dispatch(HttpRequest $httpRequest)
    {
        $staticFile = $this->root.'/static/'.$httpRequest->urlPath();
        if (file_exists($staticFile) && is_file($staticFile)) {
            switch (pathinfo($staticFile, PATHINFO_EXTENSION)) {
                case 'css':
                    header('Content-Type: text/css');
                    break;
                case 'js':
                    header('Content-Type: application/javascript');
                    break;
            }

            echo file_get_contents($staticFile);

            return;
        }

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

            $this->logger->debug($e->getMessage());
        } catch (Exception $e) {
            ob_get_clean();

            header('HTTP/1.0 500 Internal server error');

            $this->logger->debug($e->getMessage());
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
