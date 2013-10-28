<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Must as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class MustTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(
			new Term('first','value'),
			new Term('second','value')
		);

		$res = $criteria->to('array')['bool'] ;
		$this->assertEquals(2, count($res['must'])) ;
		$this->assertEquals('value', $res['must'][0]['term']['first']['value']) ;
	}
}
