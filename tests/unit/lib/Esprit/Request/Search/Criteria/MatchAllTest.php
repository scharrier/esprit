<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\MatchAll as Criteria ;

class MatchAllTest extends \PHPUnit_Framework_TestCase {

	public function testBody() {
		$critera = new Criteria() ;
		$this->assertEquals(['match_all' => new \stdClass()], $critera->to('array')) ;
	}
}
