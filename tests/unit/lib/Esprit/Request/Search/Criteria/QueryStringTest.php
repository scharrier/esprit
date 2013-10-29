<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\QueryString as Criteria ;

class QueryStringTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_value') ;
		$res = [
			'query_string' => [
				'query' => 'my_value',
				'fields' => ['_all']
			]
		] ;
		$this->assertEquals($res, $criteria->to('array')) ;

		$criteria = new Criteria('my_value', 'my_field') ;
		$res = [
			'query_string' => [
				'query' => 'my_value',
				'fields' => ['my_field']
			]
		] ;
		$this->assertEquals($res, $criteria->to('array')) ;

		$criteria = new Criteria('my_value', ['field_1', 'field_2^4']) ;
		$res = [
			'query_string' => [
				'query' => 'my_value',
				'fields' => ['field_1', 'field_2^4']
			]
		] ;
		$this->assertEquals($res, $criteria->to('array')) ;
	}
}
