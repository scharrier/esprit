<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Match as Criteria ;

class MatchTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_value', 'my_field') ;
		$this->assertEquals(['match' => ['my_field' => ['query' => 'my_value']]], $criteria->to('array')) ;
	}
}
