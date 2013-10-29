<?php
namespace Esprit\Request\Search\Criteria ;

use \Esprit\Request\Search\Criteria\Raw as Criteria ;
use \Esprit\Request\Search\Criteria\Term as Term ;


class RawTest extends \PHPUnit_Framework_TestCase {

	public function testConstructor() {
		$criteria = new Criteria([
			'bool' => [
				'must' => [
					new Term('hello','world'),
					[ 'terms' => [ 'value' => 'foo', 'fields' => ['bar','baz']]]
				]
			]
		]);

		$expected = [
			'bool' => [
				'must' => [
					[ 'term' => [ 'world' => [ 'value' => 'hello' ]]],
					[ 'terms' => [ 'value' => 'foo', 'fields' => ['bar','baz']]]
				]
			]
		];

		$this->assertEquals($expected, $criteria->to('array')) ;
	}
}
