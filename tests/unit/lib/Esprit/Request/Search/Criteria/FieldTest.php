<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Field as Criteria ;

class FieldTest extends \PHPUnit_Framework_TestCase {

	public function testBody() {
		$critera = new Criteria(['in' => 'my_field', 'value' => '+something -else']) ;
		$this->assertEquals(['field' => ['my_field' => ['query' => '+something -else']]], $critera->to('array')) ;

		$critera->data('boost', 2.0) ;
		$this->assertEquals(['field' => ['my_field' => ['query' => '+something -else', 'boost' => 2.0]]], $critera->to('array')) ;
	}
}
