<?php
namespace Idearia\Tests\Lib;

/**
 * Wrapper of PHPUnit\Framework\TestCase which loads WordPress
 * and implements a simple logger.
 *
 * WordPress will be looked for in the path given in the
 * 'wordPressPath' environment variable.
 *
 * For multisite installations, you can pptionally select a
 * specific site via the 'blogId' environment variable.
 */
class WordPressTestCase extends \PHPUnit\Framework\TestCase
{
	use Loggable;

	/**
	 * Load WordPress before running the tests
	 */
	public static function setUpBeforeClass(): void
	{
		static::loadWordPress( $_ENV['wordPressPath'], (int)$_ENV['blogId'] );
	}

	/**
	 * Helper function to load WordPress.
	 */
	public static function loadWordPress( string $wordPressPath, int $blogId = 0 )
	{
		// Load WordPress
		require_once( $wordPressPath . DIRECTORY_SEPARATOR . 'wp-load.php' );
		
		// Load given site from the network
		if ( $blogId && is_multisite() ) {
			switch_to_blog( $blogId );
		}
	}
}