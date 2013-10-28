<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Lt as Criteria ;

class LtTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_field', 1) ;
		$this->assertEquals(['range' => ['my_field' => ['lt' => 1]]], $criteria->to('array')) ;
	}
}
