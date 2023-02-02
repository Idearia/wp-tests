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
    use \PHPUnitLog\Loggable;

    /**
     * Whether to delete the log file before running each
     * test case.
     *
     * @var bool
     */
    protected static $deleteLogFile = true;

    /**
     * Details of the site on which the tests will be run
     * (multisite only).
     *
     * By default this will be the main site, unless a specific
     * blog is given via the environment variable 'siteUrl'.
     *
     * @var \WP_Site
     */
    protected static ?\WP_Site $site = null;

    /**
     * Return the URL of the site on which the tests will be run
     * (multisite only).
     *
     * Override this function to change the default behavior (main
     * blog is used unless the env variale 'siteUrl' is set).
     *
     * If the function returns null or an empty string, the main site
     * will be used.
     *
     * @return string|null
     */
    protected static function getSiteUrl()
    {
        return $_ENV['siteUrl'] ?? null;
    }

    /**
     * Load WordPress before running the tests
     *
     * @throws \Exception in multisite if $_ENV['siteUrl'] does
     * not correspond to an existing site
     */
    public static function setUpBeforeClass(): void
    {
        // Delete the log file of the test case, if requested
        if (static::$deleteLogFile) {
            static::deleteLogFile();
        }

        // Infer the path to WordPress
        $wordPressPath = $_ENV['wordPressPath'] ?? '../../..';

        // Load WordPress files
        $siteUrl = static::getSiteUrl();
        static::loadWordPress($wordPressPath, $siteUrl);

        // Case in which we are on a multisite installation
        if (\is_multisite()) {
            // If the user has specified a site, check it exists
            if ($siteUrl) {
                Helpers::throwIfSiteDoesNotExist($siteUrl);
            }
            static::$site = \get_blog_details();
        }
    }

    /**
     * Helper function to load WordPress.
     *
     * @param string $siteUrl optional URL of the website to load, for
     * multisite installations. If not given, the main site will be loaded.
     */
    public static function loadWordPress(
        string $wordPressPath,
        ?string $siteUrl = null
    ): void {
        if ($siteUrl) {
            // Pretend to run on a webserver, so that WordPress knows which
            // site to load; see set_url method in WP CLI for details
            Helpers::setServerUrl($siteUrl);
        }

        // Load WordPress
        require_once $wordPressPath . DIRECTORY_SEPARATOR . 'wp-load.php';
    }
}
