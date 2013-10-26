<?php
namespace Esprit\Response ;

class GetTest extends \PHPUnit_Framework_TestCase {

	public function testDocument() {
		$response = new \Esprit\Response\Get(array(
			'_id' => 1,
			'_source' => array(
				'some' => 'data'
			)
		));

		$this->assertTrue($response->document() instanceof \Esprit\Document) ;
		$this->assertEquals(1, $response->document()->properties()->id) ;
		$this->assertEquals('data', $response->document()->some) ;
	}
}
