<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Gte as Criteria ;

class GteTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(1, 'my_field') ;
		$this->assertEquals(['range' => ['my_field' => ['gte' => 1]]], $criteria->to('array')) ;
	}
}
