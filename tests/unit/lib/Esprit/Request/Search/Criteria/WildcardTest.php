<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Wildcard as Criteria ;

class WildcardTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_value', 'my_field') ;
		$this->assertEquals(['wildcard' => ['my_field' => ['value' => 'my_value']]], $criteria->to('array')) ;
	}
}
