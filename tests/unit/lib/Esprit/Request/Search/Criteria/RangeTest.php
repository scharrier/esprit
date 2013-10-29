<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Range as Criteria ;

class RangeTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(1, 10, 'my_field') ;
		$this->assertEquals(['range' => ['my_field' => ['lte' => 1, 'gte' => 10]]], $criteria->to('array')) ;
	}
}
