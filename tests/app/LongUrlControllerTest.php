<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 8:44 PM
 */

namespace UrlShorter\tests\app;

use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\Libs\Http\JsonHttpResponse;
use UrlShorter\LongUrlController;
use UrlShorter\LongUrlRepository;
use UrlShorter\UrlHasher;

class LongUrlControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $rep;

    /**
     * @var LongUrlController
     */
    private $ctrl;

    public function setUp()
    {
        parent::setUp();

        $this->rep = $this->createMock(LongUrlRepository::class);

        $this->ctrl = new LongUrlController($this->rep);
    }

    public function testIndex()
    {
        $response = $this->ctrl->index(new HttpRequest([]));

        static::assertInternalType('string', $response);
    }

    /**
     * @expectedException \UrlShorter\Libs\Http\HttpException
     * @expectedExceptionMessage Unprocessable Entity
     * @expectedExceptionCode 422
     */
    public function testHashWithoutLongUrl()
    {
        $this->ctrl->hash(new HttpRequest([]));
    }

    /**
     * @expectedException \UrlShorter\Libs\Http\HttpException
     * @expectedExceptionMessage Unprocessable Entity
     * @expectedExceptionCode 422
     */
    public function testHashWithNullLongUrl()
    {
        $this->ctrl->hash(new HttpRequest([], [
            'long_url' => null,
        ]));
    }

    /**
     * @expectedException \UrlShorter\Libs\Http\HttpException
     * @expectedExceptionMessage Unprocessable Entity
     * @expectedExceptionCode 422
     */
    public function testHashWithEmptyLongUrl()
    {
        $this->ctrl->hash(new HttpRequest([], [
            'long_url' => ' ',
        ]));
    }

    /**
     * @expectedException \UrlShorter\Libs\Http\HttpException
     * @expectedExceptionMessage Unprocessable Entity
     * @expectedExceptionCode 422
     */
    public function testHashWithLongLongUrl()
    {
        $this->ctrl->hash(new HttpRequest([], [
            'long_url' => str_repeat('a', UrlHasher::MAX_URL_LENGTH + 1),
        ]));
    }

    public function testHashWithValidLongUrl()
    {
        $this->rep->expects(static::once())->method('save')->with('http://zzz.aaa', static::matchesRegularExpression('/[a-zA-Z0-9]{6,6}/'));

        $response = $this->ctrl->hash(new HttpRequest([], [
            'long_url' => 'http://zzz.aaa',
        ]));

        static::assertInstanceOf(JsonHttpResponse::class, $response);
        static::assertRegExp('{"url": "http://localhost:8000/[a-zA-Z0-9]{6,6}"}', $response->getBody());
        static::assertArraySubset([
            'Content-Type' => 'application/json',
        ], $response->getHeaders());
    }
}
