<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Ids as Criteria ;

class IdsTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria('my_value', 'my_field') ;
		$this->assertEquals(['ids' => ['my_field' => ['values' => ['my_value']]]], $criteria->to('array')) ;

		$criteria->data('value', [1,2]) ;
		$this->assertEquals(['ids' => ['my_field' => ['values' => [1,2]]]], $criteria->to('array')) ;
	}
}
