<?php
namespace Esprit\Request\Search\Builder ;

class FacetsTest extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$facets = new \Esprit\Request\Search\Builder\Facets() ;
		$res = $facets->to('array') ;
		$this->assertTrue(empty($res)) ;

		$facets->add('category', array('size'=>5))->add('user_id') ;

		$res = $facets->to('array') ;
		$expected = array('category','user_id') ;


		$this->assertEquals(2, count($facets)) ;
		$this->assertEquals($expected, array_keys($res)) ;

		$facets->add(array('order' => 'term')) ;
		$this->assertEquals(2, count($facets)) ;

		$res = $facets->to('array') ;
		$expected = array(
			'terms' => array(
				'field' => 'user_id',
				'order' => 'term'
			)
		) ;
		$this->assertEquals($expected, $res['user_id']) ;
	}

	public function testFiltered() {
		$facets = new \Esprit\Request\Search\Builder\Facets() ;
		$facets
			->add('category')
			->add('user_id')
			->add(array('size' => 5))
			->filtered()
				->should()
					->field('status')->match('valid')
					->field('firstname')->match(array('Jim','Ray')) ;
		$res = $facets->to('array') ;

		$this->assertEquals(array('category','user_id'), array_keys($res)) ;
		$this->assertTrue(isset($res['user_id']['facet_filter'])) ;
		$this->assertTrue(isset($res['user_id']['facet_filter']['bool']['should'][0]['term']['status'])) ;
		$this->assertTrue(isset($res['user_id']['facet_filter']['bool']['should'][1]['terms']['firstname'])) ;
	}
}
