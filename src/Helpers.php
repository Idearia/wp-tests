<?php
namespace Idearia\WpTests;

class Helpers
{
	/**
	 * Spoof the $_SERVER variable with the given URL.
	 */
	public static function setServerUrl( $url )
	{
		global $_SERVER;

		if ( strpos( $url, 'http://' ) !== 0 && strpos( $url, 'https://' ) !== 0 ) {
			$url = 'http://' . $url;
		}

		$url_parts = parse_url( $url );
		$host = $url_parts['host'] ?? '';
		$path = $url_parts['path'] ?? '';

		if ( ! $host ) {
			throw new \Exception( "Invalid $url: $url" );
		}

		$_SERVER['SERVER_NAME'] = $host;
		$_SERVER['HTTP_HOST'] = $host;
		$_SERVER['REQUEST_URI'] = $path;
	}
}