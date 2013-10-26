<?php
namespace Esprit\Response ;

class BulkTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Good response.
	 */
	public function testNoException() {
		$response = new \Esprit\Response\Bulk(array()) ;
		$this->assertTrue($response instanceof \Esprit\Response\Bulk) ;
	}

	/**
	 * @expectedException \Esprit\Response\Exception
	 */
	public function testException() {
		$response = new \Esprit\Response\Bulk(array(
			'took' => '1',
			'items' => array(
				'index' => array(
					array('error' => 'This is an error. Oops.')
				)
			)
		)) ;
	}
}
