<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\BoolShould as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class BoolShouldTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria(
			new Term('value', 'first'),
			new Term('value', 'second'),
			array('minimum_should_match' => 2)
		);

		$res = $criteria->to('array')['bool'] ;
		$this->assertEquals(2, count($res['should'])) ;
		$this->assertEquals('value', $res['should'][0]['term']['first']['value']) ;
		$this->assertEquals(2, $res['minimum_should_match']) ;

		$criteria = new Criteria([
			new Term('value', 'first'),
			new Term('value', 'second'),
			array('minimum_should_match' => 2)
		]) ;
		$res2 = $criteria->to('array')['bool'] ;
		$this->assertEquals($res, $res2) ;
	}
}
