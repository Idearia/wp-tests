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
	 * Details of the site on which the tests will be run
	 * (multisite only).
	 *
	 * The site will be the one specified in the 'blogId' env
	 * variable.
	 */
	protected static ?\WP_Site $site = null;

	/**
	 * Load WordPress before running the tests
	 */
	public static function setUpBeforeClass(): void
	{
		$wordPressPath = $_ENV['wordPressPath'] ?? '../../..';
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
			$site = \get_blog_details( $blogId );
			if ( ! $site ) {
				throw new \Exception( "Could not find site with blogId = {$blogId}" );
			}
			static::$site = $site;
			switch_to_blog( $blogId );
		}
	}
}