<?php
namespace Esprit\Request\Search\Builder ;

use \Esprit\Request\Search\Builder\Query as Query ;
use \Esprit\Request\Search\Builder as B ;


class QueryTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$query = new Query(
			B::term('sebastian','name'),
			B::term('hello','world')
		) ;
		$res = $query->to('array') ;

		$this->assertEquals(2, count($res['bool']['must'])) ;
		$this->assertTrue(isset($res['bool']['must'][0]['term']) && isset($res['bool']['must'][1]['term'])) ;

		$query = new Query(
			B::term('sebastian','name')
		) ;
		$res = $query->to('array') ;

		$this->assertTrue(isset($res['term'])) ;
	}
}
