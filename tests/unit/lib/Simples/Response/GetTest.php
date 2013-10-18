<?php
namespace Simples\Response ;

class GetTest extends \PHPUnit_Framework_TestCase {

	public function testDocument() {
		$response = new \Simples\Response\Get(array(
			'_id' => 1,
			'_source' => array(
				'some' => 'data'
			)
		));

		$this->assertTrue($response->document() instanceof \Simples\Document) ;
		$this->assertEquals(1, $response->document()->properties()->id) ;
		$this->assertEquals('data', $response->document()->some) ;
	}
}
