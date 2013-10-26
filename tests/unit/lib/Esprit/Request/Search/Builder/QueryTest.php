<?php
namespace Esprit\Request\Search\Builder ;

class QueryTest extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$query = new \Esprit\Request\Search\Builder\Query() ;
		$res = $query->to('array') ;
		$this->assertTrue(isset($res['match_all'])) ;

		$query->add('scharrier') ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'scharrier'
			)
		) ;
		$this->assertEquals($expected, $res) ;
	}

	public function testFluid() {
		$request = new \Esprit\Request\Search() ;
		$builder = new \Esprit\Request\Search\Builder\Query($request) ;
		$res = $builder->add('scharrier') ;
		$this->assertTrue($res instanceof \Esprit\Request\Search) ;

		$builder = new \Esprit\Request\Search\Builder\Query() ;
		$res = $builder->add('scharrier') ;
		$this->assertTrue($res instanceof \Esprit\Request\Search\Builder\Query) ;
	}

	public function testMerged() {
		$query = new \Esprit\Request\Search\Builder\Query() ;
		$query->match('scharrier')->in('username') ;
		$res = $query->to('array') ;
		$expected = array(
			'term' => array('username' => 'scharrier')
		) ;

		$this->assertEquals($res, $expected) ;

		$query = new \Esprit\Request\Search\Builder\Query() ;
		$query->field('username')->match('scharrier') ;
		$res2 = $query->to('array') ;
		$this->assertEquals($res, $res2) ;

		$query = new \Esprit\Request\Search\Builder\Query() ;
		$query->fields(array('username', 'retweet'))->match('scharrier') ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'scharrier',
				'fields' => array('username','retweet')
			)
		) ;
		$this->assertEquals($res, $expected) ;

		$query = new \Esprit\Request\Search\Builder\Query() ;
		$query->match('scharrier') ;
		$query->in(array('username', 'retweet')) ;
		$res = $query->to('array') ;
		$this->assertEquals($res, $expected) ;

		$query = new \Esprit\Request\Search\Builder\Query() ;
		$query->add(array(
			'query' => 'scharrier',
			'in' => array('username', 'retweet')
		)) ;
		$res = $query->to('array') ;
		$this->assertEquals($res, $expected) ;
	}

	public function testNotMerged() {
		$query = new \Esprit\Request\Search\Builder\Query() ;

		$query->must()
				->match('scharrier')->in(array('username','retweet'))
				->field('category_id')->match(array('1','2','3'))
			  ->not()
				->field('type')->match('administreur') ;

		$res = $query->to('array') ;
		$this->assertEquals(2, count($res['bool']['must'])) ;
		$this->assertEquals(1, count($res['bool']['must_not'])) ;
	}

}
