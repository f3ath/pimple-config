<?php
namespace F3\SilexConfig;

use PHPUnit\Framework\TestCase;
use Silex\Application;

class ConfigTest extends TestCase
{
    public function testExampleProd()
    {
        $app = new Application();
        (new Config(__DIR__ . '/example'))->configure($app, 'prod');

        $this->assertEquals(
            'prod',
            $app['env'],
            'Environment name is set correctly'
        );
        $this->assertFalse(
            $app['debug'],
            'Debug is disabled in prod'
        );
        $this->assertEquals(
            'foo is common_foo, bar is prod_bar, password is s3(r37p455w0rd',
            $app['hello'],
            'Hello service returns the correct string'
        );
    }

    public function testExampleDev()
    {
        $app = new Application();
        (new Config(__DIR__ . '/example'))->configure($app, 'dev');

        $this->assertEquals(
            'dev',
            $app['env'],
            'Environment name is set correctly'
        );
        $this->assertTrue(
            $app['debug'],
            'Debug is enabled in dev'
        );
        $this->assertEquals(
            'foo is dev_foo, bar is common_bar, password is dev_password',
            $app['hello'],
            'Hello service returns the correct string'
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Configuration not found for stage
     */
    public function testInvalidEnvName()
    {
        $app = new Application();
        (new Config(__DIR__ . '/example'))->configure($app, 'stage');
    }
}
