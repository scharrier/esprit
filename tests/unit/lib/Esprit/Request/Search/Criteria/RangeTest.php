<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Range as Criteria ;

class RangeTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(1, 10, 'my_field') ;
		$this->assertEquals(['range' => ['my_field' => ['gte' => 1, 'lte' => 10]]], $criteria->to('array')) ;

		// Optionnal data
		$criteria = new Criteria(1, 10, 'my_field', ['boost' => 2]) ;
		$this->assertEquals(['range' => ['my_field' => ['gte' => 1, 'lte' => 10, 'boost' => 2]]], $criteria->to('array')) ;
	}
}
