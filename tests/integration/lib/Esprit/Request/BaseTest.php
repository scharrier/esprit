<?php
namespace Esprit\Integration\Request ;

use \Esprit\Transport\Http ;

abstract class BaseTest extends \PHPUnit_Framework_TestCase {

	static $client ;

	public static function setUpBeforeClass() {
		static::$client = new Http([
			'index' => 'twitter'
		]) ;

		// Creates the index and type used in most of the tests
		static::$client->call('/twitter/tweet', 'POST') ;
	}

	public static function tearDownAfterClass() {
		// Delete the test index
		static::$client->call('/twitter', 'DELETE') ;
	}
}
