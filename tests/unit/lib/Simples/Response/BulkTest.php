<?php
namespace Simples\Response ;

class BulkTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Good response.
	 */
	public function testNoException() {
		$response = new \Simples\Response\Bulk(array()) ;
		$this->assertTrue($response instanceof \Simples\Response\Bulk) ;
	}

	/**
	 * @expectedException \Simples\Response\Exception
	 */
	public function testException() {
		$response = new \Simples\Response\Bulk(array(
			'took' => '1',
			'items' => array(
				'index' => array(
					array('error' => 'This is an error. Oops.')
				)
			)
		)) ;
	}
}
