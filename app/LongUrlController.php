<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:10 PM
 */

namespace UrlShorter;

use UrlShorter\Libs\ControllerInterface;
use UrlShorter\Libs\FileUtils;
use UrlShorter\Libs\Http\HttpException;
use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\Libs\Http\HttpResponse;
use UrlShorter\Libs\Http\JsonHttpResponse;
use UrlShorter\Libs\Template;

class LongUrlController implements ControllerInterface
{
    /**
     * @var LongUrlRepository
     */
    private $repository;

    /**
     * Controller constructor.
     * @param LongUrlRepository $repository
     */
    public function __construct(LongUrlRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * User friendly page for generate short urls.
     *
     * @param HttpRequest $request
     * @return string
     * @throws \RuntimeException
     */
    public function index(HttpRequest $request)
    {
        $tpl = new Template(__DIR__.'/views/index.view.php');

        return $tpl->render();
    }

    /**
     * Generate short url for long url and store it.
     *
     * @param HttpRequest $request
     * @return string|JsonHttpResponse
     * @throws HttpException
     */
    public function hash(HttpRequest $request)
    {
        $longUrl = $request->param('long_url');
        if (!UrlHasher::urlIsValid($longUrl)) {
            throw new HttpException(422);
        }

        $hash = UrlHasher::hash($longUrl);

        if (!UrlHasher::hashIsValid($hash)) {
            throw new HttpException(422);
        }

        $this->repository->save($longUrl, $hash);

        return new JsonHttpResponse([
            'url' => FileUtils::join($request->serverHost(), $hash),
        ]);
    }

    /**
     * Redirect short url to long url.
     *
     * @param HttpRequest $request
     * @return HttpResponse
     * @throws HttpException
     */
    public function root(HttpRequest $request)
    {
        if ($request->urlPath() === '/') {
            return $this->index($request);
        }

        if (!UrlHasher::hashIsValid($request->urlPath())) {
            throw new HttpException(422);
        }

        $hash = UrlHasher::filter($request->urlPath());

        $longUrl = $this->repository->find($hash);

        if ($longUrl === null) {
            return new HttpResponse(sprintf('Short url %s not found!', $request->url()), 404);
        }

        return new HttpResponse(sprintf('Redirect to: %s', $longUrl), 301, [
            'Location'      => $longUrl,
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Expires'       => 'Mon, 01 Jan 1990 00:00:00 GMT',
        ]);
    }
}
