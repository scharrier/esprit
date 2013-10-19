<?php
namespace Simples\Integration\Request ;

require_once(__DIR__ . '/BaseTest.php') ;

class TypesTest extends BaseTest {

	public function testCreate() {
		$this->assertTrue(static::$client->createType('test_create_type')->execute()->ok) ;

		$exception = false ;
		try {
			static::$client->createType('test_create_type')->execute() ;
		} catch (\Exception $e) {
			$exception = true ;
		}
		$this->assertTrue($exception) ;
	}

	public function testdelete() {
		$this->assertTrue(static::$client->deleteType('test_create_type')->execute()->ok) ;

		$exception = false ;
		try {
			static::$client->deleteType('test_create_type')->execute() ;
		} catch (\Exception $e) {
			$exception = true ;
		}
		$this->assertTrue($exception) ;
	}
}
