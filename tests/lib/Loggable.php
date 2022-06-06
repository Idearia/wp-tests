<?php
namespace Idearia\Tests\Lib;

/**
 * Simple logger for PHPUnit tests.
 *
 * Features:
 * - Use self::log( $message ) to log a message to file. The file will
 *   be named after the test class and be placed in the logs subfolder.
 * - Choose a custom subfolder for the log files via the environment
 *   variable 'logsPath', or customize the full path overriding getLogFilePath().
 * - Choose a different output stream by ovverriding getLogFileStream().
 */
trait Loggable
{
	/**
	 * Print a log message to file
	 */
	protected static function log( $message ): void
	{
		$stream = static::getLogFileStream();
		if ( is_array( $message ) || is_object( $message ) ) {
			fwrite( $stream, print_r( $message, true) );
		}
		else {
			fwrite( $stream, $message );
		}
		fwrite( $stream, PHP_EOL );
	}

	/**
	 * Path to the log file
	 */
	protected static function getLogFilePath(): string
	{
		return
			dirname( __FILE__ )
			. DIRECTORY_SEPARATOR
			. ( $_ENV['logsPath'] ?? '../logs' )
			. DIRECTORY_SEPARATOR
			. (new \ReflectionClass( static::class ))->getShortName()
			. '.log';
	}

	/**
	 * The log will be sent to the stream returned by
     * this method
	 */
	protected static function getLogFileStream()
	{
		return fopen( static::getLogFilePath(), 'a' );
	}
}