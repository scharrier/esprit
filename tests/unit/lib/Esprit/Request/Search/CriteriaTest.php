<?php
namespace Esprit\Request\Search ;

class CriteriaTest extends \PHPUnit_Framework_TestCase {

	public function testNormalize() {
		$criteria = new TestCriteria(array(
			'in' => 'in',
			'value' => 'value'
		)) ;
		$expected = array(
			'in' => 'in',
			'value' => 'value'
		);
		$this->assertEquals($expected, $criteria->get()) ;

		$criteria = new TestCriteria(array(
			'field' => 'in',
			'value' => 'value'
		)) ;
		$expected = array(
			'in' => 'in',
			'value' => 'value'
		);
		$this->assertEquals($expected, $criteria->get()) ;

		$criteria = new TestCriteria(array(
			'in' => 'in',
			'query' => 'value'
		)) ;
		$expected = array(
			'in' => 'in',
			'value' => 'value'
		);
		$this->assertEquals($expected, $criteria->get()) ;

		$criteria = new TestCriteria(array(
			'field' => array('in'),
			'value' => 'value'
		)) ;
		$expected = array(
			'in' => 'in',
			'value' => 'value'
		);
		$this->assertEquals($expected, $criteria->get()) ;
	}

	public function testType() {
		$criteria = new TestCriteria(array(
			'in' => 'in',
			'value' => 'value'
		)) ;
		$this->assertEquals('term', $criteria->type());
		$criteria = new TestCriteria(array(
			'in' => array('in','other'),
			'value' => 'value'
		)) ;
		$this->assertEquals('term', $criteria->type());
		$criteria = new TestCriteria(array(
			'in' => 'in',
			'value' => array('value','other')
		)) ;
		$this->assertEquals('terms', $criteria->type());

		$criteria = new TestCriteriaQuery(array(
			'in' => 'in',
			'value' => 'value'
		)) ;
		$this->assertEquals('term', $criteria->type());
	}

	public function testPrepare() {
		// Term
		$criteria = new TestCriteria(array(
			'in' => 'in',
			'value' => 'value'
		), array('type' => 'term')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'term' => array(
				'in' => 'value'
			)
		);
		$this->assertEquals($expected, $res) ;

		// Terms
		$criteria = new TestCriteria(array(
			'in' => 'in',
			'values' => array('value1','value2')
		), array('type' => 'terms')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'terms' => array(
				'in' => array('value1','value2')
			)
		);
		$this->assertEquals($expected, $res) ;

		// Missing
		$criteria = new TestCriteria(array(
			'field' => 'my_field'
		), array('type' => 'missing')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'missing' => array(
				'field' => 'my_field'
			)
		);
		$this->assertEquals($expected, $res) ;

		// Exists
		$criteria = new TestCriteria(array(
			'field' => 'my_field'
		), array('type' => 'exists')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'exists' => array(
				'field' => 'my_field'
			)
		);
		$this->assertEquals($expected, $res) ;

		// Ids
		$criteria = new TestCriteria(array(
			'values' => array('1','2','3'),
			'type' => 'my_type'
		), array('type' => 'ids')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'ids' => array(
				'values' => array('1','2','3'),
				'type' => "my_type"
			)
		);
		$this->assertEquals($expected, $res) ;

		// Range
		$criteria = new TestCriteria(array(
			'field' => 'in',
			'from' => 1,
			'to' => 10
		), array('type' => 'range')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'range' => array(
				'in' => array('from' => 1,'to' => 10)
			)
		);
		$this->assertEquals($expected, $res) ;

		// Multiple ranges
		$criteria = new TestCriteria(array(
			'field' => 'in',
			'include_upper' => true,
			'ranges' => array(
				array('from' => 1,'to' => 10),
				array('from' => 11,'to' => 20)
			)
		), array('type' => 'range')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'bool' => array(
				'should' => array(
					array(
						'range' => array(
							'in' => array('from' => 1,'to' => 10, 'include_upper' => true)
						)
					),
					array(
						'range' => array(
							'in' => array('from' => 11,'to' => 20, 'include_upper' => true)
						)
					)
				)
			)
		);
		$this->assertEquals($expected, $res) ;

		// Geo distance
		$criteria = new TestCriteria(array(
			'field' => 'location',
			'values' => array('lat' => 1, 'lon' => 2),
			'distance' => '10km'
		), array('type' => 'geo_distance')) ;
		$res = $criteria->to('array') ;
		$expected = array(
			'geo_distance' => array(
				'location' => array('lat' => 1, 'lon' => 2) ,
				'distance' => '10km'
			)
		);
		$this->assertEquals($expected, $res) ;
		$criteria = new TestCriteria(array(
			'field' => 'location',
			'lat' => 1,
			'lon' => 2,
			'distance' => '10km'
		), array('type' => 'geo_distance')) ;
		$res = $criteria->to('array') ;
		$this->assertEquals($expected, $res) ;
	}
}

class TestCriteria extends \Esprit\Request\Search\Criteria {

}

class TestCriteriaQuery extends \Esprit\Request\Search\Criteria\Query {

}
