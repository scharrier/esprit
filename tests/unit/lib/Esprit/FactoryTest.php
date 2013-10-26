<?php
namespace Esprit\Test ;

class Factory extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$factory = new \Esprit\Factory() ;
		$this->assertTrue($factory instanceof \Esprit\Factory) ;
	}

	public function testNew() {
		$factory = new \Esprit\Factory() ;
		$status = $factory->request('status') ;
		$this->assertTrue($status instanceof \Esprit\Request\Status) ;
		$status = $factory->transport('http') ;
		$this->assertTrue($status instanceof \Esprit\Transport\Http) ;

	}
}
