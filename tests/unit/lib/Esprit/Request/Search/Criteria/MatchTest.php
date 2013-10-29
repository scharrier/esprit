<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Match as Criteria ;

class MatchTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_field', 'my_value') ;
		$this->assertEquals(['match' => ['my_field' => ['query' => 'my_value']]], $criteria->to('array')) ;
	}
}
