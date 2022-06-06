<?php
namespace Idearia\Tests;

use Idearia\SimpleClass;

/**
 * Test basic operations on SimpleClass
 */
class SimpleTest extends \PHPUnit\Framework\TestCase
{
	public function testObjectCreation()
	{
		$object = new SimpleClass();

		$this->assertInstanceOf( SimpleClass::class, $object );
	}

	public function testSetAndGetMessage()
	{
		$message = "Hello world!";

		$object = new SimpleClass();

		$object->setMessage( $message );

		$this->assertEquals( $message, $object->getMessage() );
	}
}