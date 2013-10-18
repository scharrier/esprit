<?php
namespace Simples\Request ;

class DeleteTypeTest extends \PHPUnit_Framework_TestCase {

	public $client ;

	public function setUp() {
		$this->client = new \Simples\Transport\Http(array('index' => 'test_delete', 'type' => 'test_delete_type'));
		$this->client->createIndex()->execute() ;
	}

	public function testDelete() {
		// Fake record
		$this->client->index(array('some'=>'data'), array('refresh' => true))->execute() ;

		$request = $this->client->deleteType() ;

		$this->assertEquals(\Simples\Request::DELETE, $request->method()) ;
		$this->assertEquals('/test_delete/test_delete_type/', (string) $request->path()) ;

		$response = $request->execute() ;
		$this->assertTrue($response->ok) ;
	}

	public function tearDown() {
		if ($this->client) {
			$this->client->deleteIndex()->execute() ;
		}
	}

}
