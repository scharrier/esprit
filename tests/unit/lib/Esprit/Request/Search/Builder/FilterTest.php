<?php
namespace Esprit\Request\Search\Builder ;

use \Esprit\Request\Search\Builder\Filter ;
use \Esprit\Request\Search\Builder as B ;


class FilterTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$filter = new Filter(
			B::term('sebastian','name'),
			B::term('hello','world')
		) ;
		$res = $filter->to('array') ;

		$this->assertEquals(2, count($res['and']['filters'])) ;
		$this->assertTrue(isset($res['and']['filters'][0]['term']) && isset($res['and']['filters'][1]['term'])) ;
	}
}
