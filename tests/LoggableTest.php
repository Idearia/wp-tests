<?php
namespace Idearia\WpTests\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Test the Loggable trait.
 */
class LoggableTest extends TestCase
{
    use \PHPUnitLog\Loggable;

    /**
     * @var string
     */
    protected $tempDir;

    /**
     * Test the log method.
     */
    public function testLog(): void
    {
        static::deleteLogFile();
        $this->log('test');
        $this->assertEquals("test\n", file_get_contents($this->getLogFilePath()));
    }

    /**
     * Test the log method with multiple calls.
     */
    public function testLogMultiple(): void
    {
        static::deleteLogFile();
        $this->log('test');
        $this->log('test2');
        $this->assertEquals(
            "test\ntest2\n",
            file_get_contents($this->getLogFilePath())
        );
    }

    /**
     * Test the log method with an array argument.
     */
    public function testLogArray(): void
    {
        static::deleteLogFile();
        $this->log(['test']);
        $this->assertEquals(
            "Array\n(\n    [0] => test\n)\n\n",
            file_get_contents($this->getLogFilePath())
        );
    }

    /**
     * Test the log method with an object argument.
     */
    public function testLogObject(): void
    {
        static::deleteLogFile();
        $obj = new \stdClass();
        $obj->test = 'test';
        $this->log($obj);
        $this->assertEquals(
            "stdClass Object\n(\n    [test] => test\n)\n\n",
            file_get_contents($this->getLogFilePath())
        );
    }
}
