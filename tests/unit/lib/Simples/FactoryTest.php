<?php
namespace Simples\Test ;

class Factory extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$factory = new \Simples\Factory() ;
		$this->assertTrue($factory instanceof \Simples\Factory) ;
	}

	public function testMapping() {
		$factory = new \Simples\Factory() ;
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
		$factory = new \Simples\Factory() ;
		$status = $factory->request('status') ;
		$this->assertTrue($status instanceof \Simples\Request\Status) ;
	}
}
