<?php
namespace Idearia\WpTests;

/**
 * Simple logger for PHPUnit tests.
 *
 * Features:
 * - Use self::log( $message ) to log a message to file. The file will
 *   be named after the test class and be placed in the logs subfolder.
 * - Choose a custom subfolder for the log files via the environment
 *   variable 'logsPath', or customize the full path overriding getLogFilePath().
 * - Choose a different output stream by ovverriding getLogStream().
 */
trait Loggable
{
	/**
	 * Print a log message to file
	 */
	protected static function log( $message ): void
	{
		$stream = static::getLogStream();

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
		$dir = $_ENV['logsPath'] ?? 'tests/logs';

		$path = $dir
			. DIRECTORY_SEPARATOR
			. (new \ReflectionClass( static::class ))->getShortName()
			. '.log';

		return $path;
	}

	/**
	 * The log will be sent to the stream returned by
     * this method
	 */
	protected static function getLogStream()
	{
		static::maybeCreateDir();

		return fopen( static::getLogFilePath(), 'a' );
	}

	/**
	 * Create the logs directory if it does not exist
	 */
	protected static function maybeCreateDir(): bool
	{
		$dir = dirname( self::getLogFilePath() );

		if ( ! file_exists( $dir ) ) {
			return mkdir( $dir, 0744, true );
		}

		return true;
	}
}