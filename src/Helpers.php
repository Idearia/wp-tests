<?php
namespace Idearia\WpTests;

class Helpers
{
	/**
	 * Spoof the $_SERVER variable with the given URL
	 *
	 * @throws \Exception if not a valid URL
	 */
	public static function setServerUrl( string $url ): void
	{
		global $_SERVER;

		// Add scheme lest host and path are not parsed
		if ( strpos( $url, 'http://' ) !== 0 && strpos( $url, 'https://' ) !== 0 ) {
			$url = 'http://' . $url;
		}

		if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			throw new \Exception( "Invalid url: $url" );
		}

		$url_parts = parse_url( $url );
		$host = $url_parts['host'] ?? '';
		$path = $url_parts['path'] ?? '';

		if ( ! $host ) {
			throw new \Exception( "Url with no host: $url" );
		}

		$_SERVER['SERVER_NAME'] = $host;
		$_SERVER['HTTP_HOST'] = $host;
		$_SERVER['REQUEST_URI'] = $path;
	}

	/**
	 * Throw an exception if the given site does not exist on the network
	 *
	 * @throws \Exception
	 */
	public static function throwIfSiteDoesNotExist( string $siteUrl ): void
	{
		if ( static::stripUrl( \get_site_url() ) !== static::stripUrl( $siteUrl ) ) {
			throw new \Exception( "Given site not found: $siteUrl" );
		}
	}

	/**
	 * Remove the HTTP or HTTPS part from an URL and the
	 * trailing slash
	 */
	public static function stripUrl( string $url )
	{
		return preg_replace( '/(^(https|http):\/\/)|\/$/', '', trim( $url ) );
	}
}