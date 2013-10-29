<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\BoolOr as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class BoolOrTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(
			new Term('value', 'first'),
			new Term('value', 'second')
		);

		$res = $criteria->to('array');
		$this->assertEquals(2, count($res['or']['filters'])) ;
		$this->assertEquals('value', $res['or']['filters'][0]['term']['first']['value']) ;
	}
}
