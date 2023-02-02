<?php

use Idearia\WpTests\Helpers;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class HelpersTest extends FrameworkTestCase
{
    public function testSetServerUrl()
    {
        global $_SERVER;

        Helpers::setServerUrl('example.mylocal/a-blog');
        $this->assertEquals('example.mylocal', $_SERVER['SERVER_NAME']);
        $this->assertEquals('example.mylocal', $_SERVER['HTTP_HOST']);
        $this->assertEquals('/a-blog', $_SERVER['REQUEST_URI']);

        Helpers::setServerUrl('http://example.mylocal/a-blog');
        $this->assertEquals('example.mylocal', $_SERVER['SERVER_NAME']);
        $this->assertEquals('example.mylocal', $_SERVER['HTTP_HOST']);
        $this->assertEquals('/a-blog', $_SERVER['REQUEST_URI']);

        Helpers::setServerUrl('https://example.mylocal/a-blog');
        $this->assertEquals('example.mylocal', $_SERVER['SERVER_NAME']);
        $this->assertEquals('example.mylocal', $_SERVER['HTTP_HOST']);
        $this->assertEquals('/a-blog', $_SERVER['REQUEST_URI']);

        Helpers::setServerUrl('https://example.mylocal/');
        $this->assertEquals('example.mylocal', $_SERVER['SERVER_NAME']);
        $this->assertEquals('example.mylocal', $_SERVER['HTTP_HOST']);
        $this->assertEquals('/', $_SERVER['REQUEST_URI']);

        Helpers::setServerUrl('https://example.mylocal');
        $this->assertEquals('example.mylocal', $_SERVER['SERVER_NAME']);
        $this->assertEquals('example.mylocal', $_SERVER['HTTP_HOST']);
        $this->assertEquals('', $_SERVER['REQUEST_URI']);
    }

    public function testSetServerUrlException()
    {
        $this->expectException(Exception::class);

        Helpers::setServerUrl('/whatever');
    }
}
