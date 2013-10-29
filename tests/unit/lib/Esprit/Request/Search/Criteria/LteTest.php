<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Lte as Criteria ;

class LteTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(1, 'my_field') ;
		$this->assertEquals(['range' => ['my_field' => ['lte' => 1]]], $criteria->to('array')) ;
	}
}
