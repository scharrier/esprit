<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Term as Criteria ;

class TermTest extends \PHPUnit_Framework_TestCase {

	public function testBody() {
		$critera = new Criteria(['in' => 'field', 'value' => 'value']) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value']]], $critera->to('array')) ;

		$critera->data('boost', 2.0) ;
		$this->assertEquals(['term' => ['field' => ['value' => 'value', 'boost' => 2.0]]], $critera->to('array')) ;
	}
}
