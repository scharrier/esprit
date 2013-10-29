<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\MustNot as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class MustNotTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(
			new Term('value', 'first'),
			new Term('value', 'second')
		);

		$res = $criteria->to('array')['bool'] ;
		$this->assertEquals(2, count($res['must_not'])) ;
		$this->assertEquals('value', $res['must_not'][0]['term']['first']['value']) ;
	}
}
