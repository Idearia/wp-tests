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
 * MULTISITE: optionally select a site via the 'siteUrl'
 * environment variable, like you would do with the WP
 * CLI parameter '--url'.
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
	 *
	 * @throws \Exception in multisite if $_ENV['siteUrl'] does
	 * not correspond to an existing site
	 */
	public static function setUpBeforeClass(): void
	{
		$wordPressPath = $_ENV['wordPressPath'] ?? '../../..';

		static::loadWordPress( $wordPressPath, $_ENV['siteUrl'] ?? '' );

		if ( is_multisite() ) {
			Helpers::throwIfSiteDoesNotExist( $_ENV['siteUrl'] ?? '' );
		}
	}

	/**
	 * Helper function to load WordPress.
	 *
	 * @param string $siteUrl optional URL of the website to load, for
	 * multisite installations. Also useful if your tests rely on $_SERVER
	 * variables.
	 */
	public static function loadWordPress( string $wordPressPath, string $siteUrl = '' ): void
	{
		if ( $siteUrl ) {
			// Pretend to run on a webserver, so that WordPress knows which
			// site to load; see set_url method in WP CLI for details
			Helpers::setServerUrl( $siteUrl );
		}

		// Load WordPress
		require_once( $wordPressPath . DIRECTORY_SEPARATOR . 'wp-load.php' );
	}
}