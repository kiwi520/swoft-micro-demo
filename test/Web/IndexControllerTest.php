<?php

namespace Swoft\Test\Web;


use Swoft\Testing\Web\Response;

/**
 * @uses      IndexControllerTest
 * @version   2017-11-12
 * @author    huangzhhui <huangzhwork@gmail.com>
 * @copyright Copyright 2010-2017 Swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class IndexControllerTest extends AbstractTestCase
{

    /**
     * @test
     * @covers \App\Controllers\IndexController
     */
    public function testIndex()
    {
        $expectedResult = [
            'name' => 'Swoft',
            'notes' => [
                'New Generation of PHP Framework',
                'Hign Performance, Coroutine and Full Stack'
            ],
            'links' => [
                [
                    'name' => 'Home',
                    'link' => 'http://www.swoft.org',
                ],
                [
                    'name' => 'Documentation',
                    'link' => 'http://doc.swoft.org',
                ],
                [
                    'name' => 'Case',
                    'link' => 'http://swoft.org/case',
                ],
                [
                    'name' => 'Issue',
                    'link' => 'https://github.com/swoft-cloud/swoft/issues',
                ],
                [
                    'name' => 'GitHub',
                    'link' => 'https://github.com/swoft-cloud/swoft',
                ],
            ]
        ];

        $jsonAssert = function ($response) use ($expectedResult) {
            $this->assertInstanceOf(Response::class, $response);
            /** @var Response $response */
            $response->assertSuccessful()
                ->assertHeader('Content-Type', 'application/json')
                ->assertSee('Swoft')
                ->assertSeeText('New Generation of PHP Framework')
                ->assertDontSee('Swoole')
                ->assertDontSeeText('Swoole')
                ->assertJson(['name' => 'Swoft'])
                ->assertExactJson($expectedResult)
                ->assertJsonFragment(['name' => 'Home'])
                ->assertJsonMissing(['name' => 'Swoole'])
                ->assertJsonStructure(['name', 'notes']);
        };
        // Json model
        $response = $this->request('GET', '/', [], parent::ACCEPT_JSON);
        $response->assertHeader('Content-Type', parent::ACCEPT_JSON);
        $jsonAssert($response);

        // Raw model
        $response = $this->request('GET', '/', [], parent::ACCEPT_RAW);
        $response->assertHeader('Content-Type', parent::ACCEPT_JSON);
        $jsonAssert($response);

        // View model
        $response = $this->request('GET', '/', [], parent::ACCEPT_VIEW);
        $response->assertSuccessful()
            ->assertSee($expectedResult['name'])
            ->assertSee($expectedResult['notes'][0])
            ->assertSee($expectedResult['notes'][1])
            ->assertHeader('Content-Type', 'text/html');

        // absolutePath
        $response = $this->request('GET', '/index/absolutePath', [], parent::ACCEPT_VIEW);
        $response->assertSuccessful()
            ->assertSee($expectedResult['name'])
            ->assertSee($expectedResult['notes'][0])
            ->assertSee($expectedResult['notes'][1])
            ->assertHeader('Content-Type', 'text/html');
    }

    /**
     * @test
     * @covers \App\Controllers\IndexController
     */
    public function testException()
    {
        $response = $this->request('GET', '/index/exception', [], parent::ACCEPT_JSON);
        $response->assertStatus(400)->assertJson(['message' => 'Bad Request']);
    }

    /**
     * @test
     * @covers \App\Controllers\IndexController
     */
    public function testRaw()
    {
        $expected = 'Swoft';
        $response = $this->request('GET', '/index/raw', [], parent::ACCEPT_RAW);
        $response->assertSuccessful()->assertSee($expected);

        $response = $this->request('GET', '/index/raw', [], parent::ACCEPT_JSON);
        $response->assertSuccessful()->assertJson(['data' => $expected]);
    }

}
