<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Term as Criteria ;

class TermTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_value','my_field') ;
		$this->assertEquals(['term' => ['my_field' => ['value' => 'my_value']]], $criteria->to('array')) ;

		// With optionnal data
		$criteria = new Criteria('my_value','my_field', ['boost' => '3']) ;
		$this->assertEquals(['term' => ['my_field' => ['value' => 'my_value', 'boost' => '3']]], $criteria->to('array')) ;
	}

	public function testBody() {
		$criteria = new Criteria(['in' => 'field', 'value' => 'value']) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value']]], $criteria->to('array')) ;

		$criteria->data('boost', 2.0) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value', 'boost' => 2.0]]], $criteria->to('array')) ;
	}
}
