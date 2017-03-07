<?php
namespace F3\PimpleConfig;

use PHPUnit\Framework\TestCase;
use Pimple\Container;

class ConfigTest extends TestCase
{
    public function testExampleProd()
    {
        $container = new Container();
        $container->register(new Config(__DIR__ . '/example', 'prod'));

        $this->assertEquals(
            'prod',
            $container['env'],
            'Environment name is set correctly'
        );
        $this->assertFalse(
            $container['debug'],
            'Debug is disabled in prod'
        );
        $this->assertEquals(
            'foo is common_foo, bar is prod_bar, password is s3(r37p455w0rd',
            $container['hello'],
            'Hello service returns the correct string'
        );
    }

    public function testExampleDev()
    {
        $container = new Container();
        $container->register(new Config(__DIR__ . '/example', 'dev'));

        $this->assertEquals(
            'dev',
            $container['env'],
            'Environment name is set correctly'
        );
        $this->assertTrue(
            $container['debug'],
            'Debug is enabled in dev'
        );
        $this->assertEquals(
            'foo is dev_foo, bar is common_bar, password is dev_password',
            $container['hello'],
            'Hello service returns the correct string'
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Configuration not found for stage
     */
    public function testInvalidEnvName()
    {
        $container = new Container();
        $container->register(new Config(__DIR__ . '/example', 'stage'));
    }
}
