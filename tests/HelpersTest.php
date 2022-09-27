<?php

use Idearia\WpTests\Helpers;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class HelpersTest extends FrameworkTestCase
{
	public function test__SetServerUrl()
	{
		global $_SERVER;

		Helpers::setServerUrl( 'inofficina.mylocal/officinaranghetti' );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['SERVER_NAME'] );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['HTTP_HOST'] );
		$this->assertEquals( '/officinaranghetti', $_SERVER['REQUEST_URI'] );

		Helpers::setServerUrl( 'http://inofficina.mylocal/officinaranghetti' );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['SERVER_NAME'] );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['HTTP_HOST'] );
		$this->assertEquals( '/officinaranghetti', $_SERVER['REQUEST_URI'] );

		Helpers::setServerUrl( 'https://inofficina.mylocal/officinaranghetti' );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['SERVER_NAME'] );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['HTTP_HOST'] );
		$this->assertEquals( '/officinaranghetti', $_SERVER['REQUEST_URI'] );

		Helpers::setServerUrl( 'https://inofficina.mylocal/' );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['SERVER_NAME'] );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['HTTP_HOST'] );
		$this->assertEquals( '/', $_SERVER['REQUEST_URI'] );

		Helpers::setServerUrl( 'https://inofficina.mylocal' );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['SERVER_NAME'] );
		$this->assertEquals( 'inofficina.mylocal', $_SERVER['HTTP_HOST'] );
		$this->assertEquals( '', $_SERVER['REQUEST_URI'] );
	}
}