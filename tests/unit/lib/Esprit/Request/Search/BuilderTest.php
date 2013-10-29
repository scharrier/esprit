<?php
namespace Esprit\Request\Search ;

use \Esprit\Request\Search\Builder as B ;

class BuilderTest extends \PHPUnit_Framework_TestCase {

	public function testSimpleCalls() {
		$criteria = B::term('value', 'field') ;
		$this->assertTrue($criteria instanceof \Esprit\Request\Search\Criteria\Term) ;
		$this->assertEquals('value', $criteria->to('array')['term']['field']['value']) ;

		$criteria = B::matchAll('value', 'field') ;
		$this->assertTrue($criteria instanceof \Esprit\Request\Search\Criteria\MatchAll) ;
	}

	public function testComplexCalls() {
		// Global test
		$criteria = B::should(
			B::term('value', 'first_field'),
			B::terms(['value_1','value_2'], 'second_field'),
			B::must(
				B::matchAll(),
				B::field(['in' => 'first_field','value' => '+select -that'])
			),
			['minimum_should_match' => 2]
		) ;

		$res = [
			'bool' => [
				'should' => [
					['term' => ['first_field' => ['value' => 'value']]],
					['terms' => ['second_field' => ['value_1', 'value_2']]],
					['bool' => [
						'must' => [
							['match_all' => new \stdClass()],
							['field' => ['first_field' => ['query' => '+select -that']]]]
						]
					]
				],
				'minimum_should_match' => 2
			]
		] ;

		$this->assertEquals($criteria->to('array'), $res) ;

		// Ranges
		$criteria = B::must(
			B::lt(10, 'field'),
			B::gt(2, 'field')
		) ;

		$res = [
			'bool' => [
				'must' => [
					[
						'range' => [
							'field' => [
								'lt' => 10
							]
						]
					],
					[
						'range' => [
							'field' => [
								'gt' => 2
							]
						]
					]
				]
			]
		] ;

		$this->assertEquals($criteria->to('array'), $res) ;
	}
}
