<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\BoolNot as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class BoolNotTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(
			new Term('value', 'first'),
			new Term('value', 'second')
		);

		$res = $criteria->to('array');
		$this->assertEquals(2, count($res['not']['filters'])) ;
		$this->assertEquals('value', $res['not']['filters'][0]['term']['first']['value']) ;
	}
}
