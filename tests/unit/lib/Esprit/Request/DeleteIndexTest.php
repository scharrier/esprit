<?php
namespace Esprit\Test\Request ;

class DeleteIndex extends \PHPUnit_Framework_TestCase {

	public function testDelete() {
		$client = new \Esprit\Transport\Http();
		$request = $client->deleteIndex('twitter') ;
		$this->assertEquals(\Esprit\Request::DELETE, $request->method()) ;
		$this->assertEquals('/twitter/', (string) $request->path()) ;
	}

}
