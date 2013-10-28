<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Term as Criteria ;

class TermTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_field', 'my_value') ;
		$this->assertEquals(['term' => ['my_field' => ['value' => 'my_value']]], $criteria->to('array')) ;
	}

	public function testBody() {
		$criteria = new Criteria(['in' => 'field', 'value' => 'value']) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value']]], $criteria->to('array')) ;

		$criteria->data('boost', 2.0) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value', 'boost' => 2.0]]], $criteria->to('array')) ;
	}
}
