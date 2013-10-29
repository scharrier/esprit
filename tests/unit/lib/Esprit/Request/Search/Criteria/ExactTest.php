<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Exact as Criteria ;

class ExactTest extends \PHPUnit_Framework_TestCase {

	public function testTerm() {
		$criteria = new Criteria('my_value', 'my_field') ;
		$this->assertEquals(['term' => ['my_field' => ['value' => 'my_value']]], $criteria->to('array')) ;
	}

	public function testTerms() {
		$criteria = new Criteria(['value_1', 'value_2'], 'my_field') ;
		$this->assertEquals(['terms' => ['my_field' => ['value_1', 'value_2']]], $criteria->to('array')) ;
	}
}
