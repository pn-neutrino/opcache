<?php

namespace Test\Opcache;

use Neutrino\Opcache\Manager;
use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testInvalidate()
    {
        $manager = new Manager();

        $this->assertTrue($manager->invalidate(__DIR__.'/../.stub/test.php'));
    }

    public function testCompile()
    {
        $manager = new Manager();

        $this->assertTrue($manager->compile(__DIR__.'/../.stub/test.php'));
    }

    public function testStatus()
    {
        $manager = new Manager();

        $this->assertArrayHasKey('opcache_enabled', $manager->status());
    }

    public function testConfiguration()
    {
        $manager = new Manager();

        $configuration = $manager->configuration();

        $this->assertArrayHasKey('directives', $configuration);
        $this->assertArrayHasKey('version', $configuration);
    }

    public function testReset()
    {
        $manager = new Manager();

        $this->assertTrue($manager->reset());
    }
}
