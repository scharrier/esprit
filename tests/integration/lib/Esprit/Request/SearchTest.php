<?php
namespace Esprit\Integration\Request ;

use Esprit\Request\Search\Builder as B ;

require_once(__DIR__ . '/BaseTest.php') ;

class SearchTest extends BaseTest {

	public static function setUpBeforeClass() {
		parent::setUpBeforeClass() ;

		static::$client->config(array('type' => 'tweets')) ;
		static::$client->index([
			['username' => 'scharrier', 'status' => 'public', 'tweet' => 'Hello world, how are you ?'],
			['username' => 'scharrier', 'status' => 'public', 'tweet' => 'What are you doing, and how ?'],
			['username' => 'jmorisson', 'status' => 'private', 'tweet' => 'I\'m ridding on the storm']
		], ['refresh' => true])->execute() ;
	}

	public function testQuery() {
		$search = static::$client->search()->query(
			B::queryString('you'),
			B::queryString('how')
		) ;
		$res = $search->execute() ;
		$this->assertEquals(2, $res->hits->total) ;
	}

	public function testFilter() {
		$search = static::$client->search()
		->filter(
			B::term('scharrier','username'),
			B::term('public','status')
		) ;
		$res = $search->execute() ;
		$this->assertEquals(2, $res->hits->total) ;
	}

	public function testAll() {
		$search = static::$client->search()
		->query(B::queryString('hellow world'))
		->filter(B::term('scharrier','username')) ;
		$res = $search->execute() ;
		$this->assertEquals(1, $res->hits->total) ;
	}

}
