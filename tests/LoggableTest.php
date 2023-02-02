<?php
namespace Idearia\WpTests\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Test the Loggable trait.
 */
class LoggableTest extends TestCase
{
    use PHPUnitLog\Loggable;

    /**
     * @var string
     */
    protected $tempDir;

    /**
     * Test the log method.
     */
    public function testLog()
    {
        static::deleteLogFile();
        $this->log( 'test' );
        $this->assertEquals(
            "test\n",
            file_get_contents( $this->getLogFilePath() )
        );
    }

    /**
     * Test the log method with multiple calls.
     */
    public function testLogMultiple()
    {
        static::deleteLogFile();
        $this->log( 'test' );
        $this->log( 'test2' );
        $this->assertEquals(
            "test\ntest2\n",
            file_get_contents( $this->getLogFilePath() )
        );
    }

    /**
     * Test the log method with an array argument.
     */
    public function testLogArray()
    {
        static::deleteLogFile();
        $this->log( [ 'test' ] );
        $this->assertEquals(
            "Array\n(\n    [0] => test\n)\n\n",
            file_get_contents( $this->getLogFilePath() )
        );
    }

    /**
     * Test the log method with an object argument.
     */
    public function testLogObject()
    {
        static::deleteLogFile();
        $obj = new \stdClass();
        $obj->test = 'test';
        $this->log( $obj );
        $this->assertEquals(
            "stdClass Object\n(\n    [test] => test\n)\n\n",
            file_get_contents( $this->getLogFilePath() )
        );
    }

    /**
     * Test that the logs folder will be read from $_ENV['logsPath']
     * and created if it does not exist
     */
    public function testLogFolderCreated()
    {
        // Set logsPath to a non-existent folder
        $_ENV['logsPath'] = 'tests/logs/' . uniqid();

        // Take note of the folder for later tear down
        $this->tempDir = $_ENV['logsPath'];

        // Check that the log file path is correct
        $this->assertEquals(
            $_ENV['logsPath'] . '/LoggableTest.log',
            $this->getLogFilePath()
        );

        // Log something
        $this->log( 'test' );

        // Check that the log file was created
        $this->assertEquals(
            "test\n",
            file_get_contents( $this->getLogFilePath() )
        );

        // Delete the log file
        static::deleteLogFile();

        // Delete the folder
        rmdir( $_ENV['logsPath'] );

        // Reset logsPath
        $_ENV['logsPath'] = null;
    }

    /**
     * Remove temporary files and folders created during tests.
     */
    public function tearDown(): void
    {
        if ( is_dir( $this->tempDir ) ) {
            // Empty the folder
            $files = glob( $this->tempDir . '/*' );
            foreach ( array_filter( $files, 'is_file' ) as $file ) {
                unlink( $file );
            }
            // Delete the folder
            rmdir( $this->tempDir );
        }
    }
}
