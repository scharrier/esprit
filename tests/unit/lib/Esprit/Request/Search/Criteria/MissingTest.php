<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Missing as Criteria ;

class MissingTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_field') ;
		$this->assertEquals(['missing' => ['field' => 'my_field']], $criteria->to('array')) ;

		// With optionnal data
		$criteria = new Criteria('my_field', ['null_value' => false]) ;
		$this->assertEquals(['missing' => ['field' => 'my_field', 'null_value' => false]], $criteria->to('array')) ;
	}
}
