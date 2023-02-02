<?php
namespace Idearia\WpTests;

/**
 * Simple logger for PHPUnit tests.
 *
 * Features:
 *
 * - Use self::print( $message ) to print a message to console.
 *
 * - Use self::log( $message ) to log a message to file. The file will
 *   be named after the test class, and be placed in the logs subfolder.
 *
 * - Choose a custom subfolder for the log files via the environment variable
 *   'logsPath'.
 * 
 * - You can change the full path of the log file (including its name and
 *   extension) by overriding the static method getLogFilePath().
 *
 * - For even more control, directly plug-in an output stream by overriding
 *   the static method getLogStream().
 *
 * - To clean the log file before each run, simply delete it in the
 *   constructor: unlink( self::getLogFilePath() );
 */
trait Loggable
{
	/**
	 * Print a log message to console.
	 */
	protected static function print( $message ): void
	{
		static::log( $message, STDERR );
	}

	/**
	 * Print a log message to file.
	 *
	 * @param mixed $message
	 * @param resource $stream optional stream to which the message will be
	 * written. If not specified, the stream returned by getLogStream() will
	 * be used.
	 */
	protected static function log( $message, $stream = null ): void
	{
		if ( ! $stream ) {
			$stream = static::getLogStream();
		}

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
		$dir = dirname( static::getLogFilePath() );

		if ( ! file_exists( $dir ) ) {
			return mkdir( $dir, 0744, true );
		}

		return true;
	}

	/**
	 * Delete log file for the class
	 */
	protected static function deleteLogFile(): bool
	{
		if ( ! file_exists( static::getLogFilePath() ) ) {
			return true;
		}

		return unlink( static::getLogFilePath() );
	}
}