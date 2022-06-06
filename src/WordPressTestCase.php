<?php
namespace Idearia\WpTests;

/**
 * Wrapper of PHPUnit's TestCase that loads WordPress
 * and implements a simple logger.
 *
 * WordPress will be looked for in the path given in the
 * 'wordPressPath' environment variable. If no value is set,
 * we will infer it.
 *
 * For multisite installations, you can optionally select a
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
		$wordPressPath = $_ENV['wordPressPath'] ?? '../../../../../../';
		static::loadWordPress( $wordPressPath, (int)$_ENV['blogId'] );
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