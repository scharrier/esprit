<?php
namespace Esprit\Request\Search ;

use \Esprit\Request\Search\Builder as B ;

class BuilderTest extends \PHPUnit_Framework_TestCase {

	public function testSimpleCalls() {
		$criteria = B::term('field','value') ;
		$this->assertTrue($criteria instanceof \Esprit\Request\Search\Criteria\Term) ;
		$this->assertEquals('value', $criteria->to('array')['term']['field']['value']) ;

		$criteria = B::matchAll('field','value') ;
		$this->assertTrue($criteria instanceof \Esprit\Request\Search\Criteria\MatchAll) ;
	}

	public function testComplexCalls() {
		// Global test
		$criteria = B::should(
			B::term('first_field','value'),
			B::terms('second_field',['value_1','value_2']),
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
			B::lt('field',10),
			B::gt('field', 2)
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
