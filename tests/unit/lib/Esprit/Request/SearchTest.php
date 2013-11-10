<?php
namespace Esprit\Request ;

use Esprit\Request\Search\Builder as B ;

class SearchTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->client = new\Esprit\Transport\Http() ;
	}

	public function testSearch() {
		$request = $this->client->search() ;
		$request->query(
			B::term('scharrier','name'),
			B::terms([10,20], 'age')
		)->size(0)->explain(false) ;
		$res = $request->to('array') ;

		// Base search tests
		$expected = [
			'query' => [
				'bool' => [
					'must' => [
						['term' => [
							'name' => ['value' => 'scharrier']
						]],
						['terms' => [
							'age' => [10, 20]
						]]
					]
				]
			],
            'size' => 0,
            'explain' => false
		] ;
		$this->assertEquals($expected, $res) ;

		$request = $this->client->search() ;
		$request
			->query(B::term('scharrier','name'))
			->filter(B::terms([10,20], 'age'))
			->size(0)
			->explain(false) ;
		$res = $request->to('array') ;
		$this->assertEquals(1, count($res['query'])) ;
		$this->assertEquals(1, count($res['filter'])) ;
	}

	public function test_sort() {
		$request = $this->client->search();
		$request->sort('Client.name') ;
		$body = $request->body() ;
		$this->assertEquals('Client.name', $body['sort']) ;

		$request->sort('Client.name desc') ;
		$body = $request->body() ;
		$this->assertEquals(array('Client.name' => 'desc'), $body['sort']) ;

		$request->sort(array('Client.name asc', 'Client.age' => 'desc', 'Client.location')) ;
		$body = $request->body() ;
		$this->assertEquals(array('Client.name' => 'asc', 'Client.age' => 'desc', 'Client.location'), $body['sort']) ;
	}

	public function testHighlight() {
		$request = $this->client->search()->highlight(array(
			'fields' => array(
				'name',
				'address' => array(
					'fragment_size' => 150
				)
			)
		)) ;
		$res = $request->to('array') ;
		$this->assertTrue(isset($res['highlight']['fields']['name'])) ;
		$this->assertTrue(isset($res['highlight']['fields']['address'])) ;
	}
}
