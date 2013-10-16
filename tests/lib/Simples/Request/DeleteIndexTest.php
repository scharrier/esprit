<?php
namespace Simples\Test\Request ;

class DeleteIndex extends \PHPUnit_Framework_TestCase {

	public function testDelete() {
		$client = new \Simples\Transport\Http();
		$request = $client->deleteIndex('twitter') ;
		$this->assertEquals(\Simples\Request::DELETE, $request->method()) ;
		$this->assertEquals('/twitter/', (string) $request->path()) ;
	}

}
