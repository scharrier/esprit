<?php
namespace Simples\Request\Search\Criteria ;

class QueryTest extends \PHPUnit_Framework_TestCase {

	public function testType() {
		$query = new \Simples\Request\Search\Criteria\Query() ;
		$this->assertEquals('match_all', $query->type()) ;

		$query = new \Simples\Request\Search\Criteria\Query('scharrier') ;
		$this->assertEquals('query_string', $query->type()) ;

		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier', 'in' => 'name')) ;
		$this->assertEquals('term', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier 123', 'in' => 'name')) ;
		$this->assertEquals('term', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier AND 123', 'in' => 'name')) ;
		$this->assertEquals('query_string', $query->type()) ;

		$query = new \Simples\Request\Search\Criteria\Query('*char*') ;
		$this->assertEquals('query_string', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => '*char*', 'in' => 'name')) ;
		$this->assertEquals('query_string', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Query('user:scharrier*') ;
		$this->assertEquals('query_string', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'user:scharrier*')) ;
		$this->assertEquals('query_string', $query->type()) ;

		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier', 'in' => array('username','retweet'))) ;
		$this->assertEquals('query_string', $query->type()) ;

	}

	public function testPrepare() {
		// Empty criteria
		$query = new \Simples\Request\Search\Criteria\Query() ;
		$res = $query->to('array') ;
		$expected = array(
			'match_all' => new \stdClass()
		) ;
		$this->assertEquals($expected, $res) ;

		// Simple query_string
		$query = new \Simples\Request\Search\Criteria\Query('scharrier') ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'scharrier'
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Simple term
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier', 'in' => 'username')) ;
		$res = $query->to('array') ;
		$expected = array(
			'term' => array(
				'username' => 'scharrier'
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Simple term in multiple fields
		$query = new \Simples\Request\Search\Criteria\Query(array('query' => 'scharrier', 'in' => array('username','retweet'))) ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'scharrier',
				'fields' => array('username','retweet')
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Multiple terms in multiple fields
		$query = new \Simples\Request\Search\Criteria\Query(array(
			'query' => array('sebastien','charrier'),
			'in' => array('username','retweet')
		)) ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'sebastien AND charrier',
				'fields' => array('username','retweet')
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Standard request (same as previous)
		$query = new \Simples\Request\Search\Criteria\Query(array(
			'query' => 'sebastien AND charrier',
			'fields' => array('username','retweet')
		), array('type' => 'query_string')) ;
		$res2 = $query->to('array') ;
		$this->assertEquals($res, $res2) ;

		// Same with "or"
		$query = new \Simples\Request\Search\Criteria\Query(array(
			'query' => array('sebastien','charrier'),
			'in' => array('username','retweet')
		), array('mode' => 'or')) ;
		$res = $query->to('array') ;
		$expected = array(
			'query_string' => array(
				'query' => 'sebastien OR charrier',
				'fields' => array('username','retweet')
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Terms
		$query = new \Simples\Request\Search\Criteria\Query(array(
			'query' => array('sebastien','charrier'),
			'in' => 'username'
		)) ;
		$res = $query->to('array') ;
		$expected = array(
			'terms' => array(
				'username' => array('sebastien', 'charrier'),
			)
		) ;
		$this->assertEquals($expected, $res) ;

	}

}
