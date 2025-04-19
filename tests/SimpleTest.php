<?php

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testEnvironmentIsWorking()
    {
        $this->assertTrue(true);
        $this->assertEquals('test', 'test');
        $this->assertDirectoryExists(__DIR__);
    }

    public function testConfigFileExists()
    {
        $this->assertFileExists(__DIR__ . '/../src/includes/config.php');
    }
}
