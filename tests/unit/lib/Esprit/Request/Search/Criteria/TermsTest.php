<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Terms as Criteria ;

class TermsTest extends \PHPUnit_Framework_TestCase {

	public function testBody() {
		$critera = new Criteria(['in' => 'field', 'value' => [1,2]]) ;
		$this->assertEquals(['terms' => ['field' => [1, 2]]], $critera->to('array')) ;

		$critera->data('minimum_should_match', 1) ;
		$this->assertEquals(['terms' => ['field' => [1,2], 'minimum_should_match' => 1]], $critera->to('array')) ;
	}
}
