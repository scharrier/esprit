<?php
namespace Esprit\Test ;

class Factory extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$factory = new \Esprit\Factory() ;
		$this->assertTrue($factory instanceof \Esprit\Factory) ;
	}

	public function testMapping() {
		$factory = new \Esprit\Factory() ;
		$factory->map('Request.status', 'Ahahah') ;
		$this->assertEquals('Ahahah', $factory->mapping('Request.status')) ;

		$factory->map('Request', array('stats' => 'Burp')) ;
		$mapping = $factory->mapping() ;
		$this->assertEquals('Ahahah',$mapping['Request.status']) ;
		$this->assertEquals('Burp', $mapping['Request.stats']) ;

		$this->assertTrue($factory->valid('Request.status')) ;
		$this->assertFalse($factory->valid('Request.somethingbad')) ;
	}

	public function testNew() {
		$factory = new \Esprit\Factory() ;
		$status = $factory->request('status') ;
		$this->assertTrue($status instanceof \Esprit\Request\Status) ;
	}
}
