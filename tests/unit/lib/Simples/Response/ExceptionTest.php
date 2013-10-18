<?php
namespace Simples\Response ;

class ExceptionTest extends \PHPUnit_Framework_TestCase {

	public function testUsage() {
		// String
		$exception = new \Simples\Response\Exception('Test string message') ;
		$this->assertEquals($exception->getMessage(), $exception->error) ;

		// Array
		$exception = new \Simples\Response\Exception(array('error' => 'Test array message')) ;
		$this->assertEquals('Test array message', $exception->error) ;

		// Array
		$exception = new \Simples\Response\Exception(array('badkey' => 'Test array message')) ;
		$this->assertEquals('An error has occured but cannot be decoded', $exception->error) ;
		$this->assertEquals('Test array message', $exception->badkey) ;
	}
}
