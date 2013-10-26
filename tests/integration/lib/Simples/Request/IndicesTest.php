<?php
namespace Esprit\Integration\Request ;

require_once(__DIR__ . '/BaseTest.php') ;

class IndicesTest extends BaseTest {

	public function testCreate() {
		static::$client->config(['index' => null]) ;
		$this->assertTrue(static::$client->createIndex('test_create')->execute()->ok) ;

		try {
			static::$client->createIndex('test_create')->execute() ;
			$this->fail() ;
		} catch (\Exception $e) {}
	}

	public function testdelete() {
		$this->assertTrue(static::$client->deleteIndex('test_create')->execute()->ok) ;

		try {
			static::$client->deleteIndex('test_create')->execute() ;
			$this->fail() ;
		} catch (\Exception $e) {}

		static::$client->config(['index' => 'twitter']) ;
	}
}
