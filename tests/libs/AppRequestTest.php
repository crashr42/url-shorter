<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:19 PM
 */

namespace UrlShorter\tests\libs;

use UrlShorter\App;
use UrlShorter\Libs\ControllerInterface;
use UrlShorter\Libs\Http\HttpRequest;
use UrlShorter\Libs\Logger;

class AppRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var App
     */
    private $app;

    public function setUp()
    {
        parent::setUp();

        $this->app = new App(['debug' => true], __DIR__, $this->createMock(ControllerInterface::class), $this->createMock(Logger::class));
    }

    /**
     * @dataProvider actionNames
     *
     * @param string $scriptName
     * @param string $action
     */
    public function testActionName($scriptName, $action)
    {
        $appRequest = $this->app->makeAppRequest(new HttpRequest([
            'SCRIPT_NAME' => $scriptName,
        ], []));

        static::assertEquals($action, $appRequest->actionName());
    }

    /**
     * Data set for testing action names.
     *
     * @return array
     */
    public function actionNames()
    {
        return [
            ['/hash', 'hash'],
            ['/hash/abc', 'hash'],
            ['/', 'root'],
        ];
    }
}
