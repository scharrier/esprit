<?php
namespace Simples\Request\Search\Criteria ;

class FilterTest extends \PHPUnit_Framework_TestCase {

	public function testType() {
		$query = new \Simples\Request\Search\Criteria\Filter() ;
		$this->assertEquals('term', $query->type()) ;

		$query = new \Simples\Request\Search\Criteria\Filter(array('query' => 'scharrier', 'in' => 'name')) ;
		$this->assertEquals('term', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Filter(array('query' => 'scharrier 123', 'in' => 'name')) ;
		$this->assertEquals('term', $query->type()) ;
		$query = new \Simples\Request\Search\Criteria\Filter(array('query' => 'scharrier AND 123', 'in' => 'name')) ;
		$this->assertEquals('term', $query->type()) ;


		$query = new \Simples\Request\Search\Criteria\Filter(array(
			'query' => array('sebastien','charrier'),
			'in' => 'field'
		)) ;
		$this->assertEquals('terms', $query->type()) ;
	}

	public function testPrepare() {
		// Simple term
		$query = new \Simples\Request\Search\Criteria\Filter(array('query' => 'scharrier', 'in' => 'username')) ;
		$res = $query->to('array') ;
		$expected = array(
			'term' => array(
				'username' => 'scharrier'
			)
		) ;
		$this->assertEquals($expected, $res) ;
	}

	public function testRanges() {
		// Simple range
		$query = new \Simples\Request\Search\Criteria\Filter(
			array('in' => 'age', 'from' => '5', 'to' => '10'),
			array('type' => 'range')
		) ;
		$res = $query->to('array') ;
		$expected = array(
			'range' => array(
				'age' => array('from' => '5', 'to' => '10')
			)
		) ;
		$this->assertEquals($expected, $res) ;

		// Multiple ranges
		$query = new \Simples\Request\Search\Criteria\Filter(
			array('in' => 'age', 'ranges' => array(
				array('from' => '5', 'to' => '10'),
				array('from' => '11', 'to' => '20')
			)),
			array('type' => 'range')
		) ;
		$res = $query->to('array') ;
		$expected = array(
			'bool' => array(
				'should' => array(
					array('range' => array('age' => array('from' => '5', 'to' => '10'))),
					array('range' => array('age' => array('from' => '11', 'to' => '20')))
				)
			)
		) ;
		$this->assertEquals($expected, $res) ;
	}

}
