<?php
namespace Simples\Request\Search ;

class FacetTest extends \PHPUnit_Framework_TestCase {

	public function testBase() {
		$facet = new \Simples\Request\Search\Facet('category_id') ;
		$this->assertEquals('terms',$facet->type()) ;
		$this->assertEquals('category_id',$facet->get('in')) ;
	}

	public function testIn() {
		$facet = new \Simples\Request\Search\Facet('category_id') ;
		$res = $facet->to('array') ;
		$expected = array(
			'category_id' => array(
				'terms' => array(
					'field' => 'category_id',
				)
			)
		) ;

		$facet = new \Simples\Request\Search\Facet(array('in' => 'category_id')) ;
		$res = $facet->to('array') ;
		$expected = array(
			'category_id' => array(
				'terms' => array(
					'field' => 'category_id',
				)
			)
		) ;

		$facet = new \Simples\Request\Search\Facet(array('field' => 'category_id')) ;
		$res = $facet->to('array') ;
		$expected = array(
			'category_id' => array(
				'terms' => array(
					'field' => 'category_id',
				)
			)
		) ;

		$facet = new \Simples\Request\Search\Facet(array('name' => 'test_value_field','value_field' => 'category_id')) ;
		$res = $facet->to('array') ;
		$expected = array(
			'test_value_field' => array(
				'terms' => array(
					'value_field' => 'category_id',
				)
			)
		) ;
	}

	public function testMultipleFields() {
		$facet = new \Simples\Request\Search\Facet(array('name' => 'category', 'fields' => array('Offers.category_id','Users.category_id'))) ;
		$res = $facet->to('array') ;
		$expected = array(
			'category' => array(
				'terms' => array(
					'fields' => array('Offers.category_id','Users.category_id'),
				)
			)
		) ;
		$this->assertEquals($expected, $res) ;
	}

	public function testFluid() {
		$facet = new \Simples\Request\Search\Facet('category') ;
		$facet->filtered()->field('type')->match('administrateur') ;
		$res = $facet->to('array') ;
		$this->assertEquals('administrateur', $res['category']['facet_filter']['term']['type']) ;

		$facet->filtered(array(
			array('in' => 'status', 'value' => 'validated'),
			array('in' => 'valid', 'value' => true)
		));

		$res = $facet->to('array') ;
		$this->assertEquals(3, count($res['category']['facet_filter']['bool']['must'])) ;
	}

}
