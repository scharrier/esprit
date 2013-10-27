<?php
namespace Esprit\Integration\Transport ;

class HttpTest extends \PHPUnit_Framework_TestCase {

	public function testConnect() {
		// Defaults index / type
		$client = new \Esprit\Transport\Http(array(
			'host' => 'localhost',
			'port' => 666,
			'index' => 'twitter',
			'type' => 'tweet'
		)) ;

		// Fails
		try {
			$client->connect() ;
			$this->fail() ;
		} catch(\Exception $e) {} ;

		// Defaults index / type
		$client = new \Esprit\Transport\Http(array(
			'host' => 'localhost',
			'index' => 'twitter',
			'type' => 'tweet',
			'check' => false
		)) ;

		$this->assertTrue($client->connect()->connected()) ;
		$this->assertTrue($client->check()) ;
	}

	public function testCall() {
		$transport = new \Esprit\Transport\Http() ;
		$res = $transport->call() ;
		$this->assertTrue($res['ok']);
		$this->assertTrue(isset($res['version']['number'])) ;
	}

	public function testMagicCall() {
		$transport = new \Esprit\Transport\Http() ;
		$response = $transport->status()->execute() ;
		$this->assertTrue($response instanceof \Esprit\Response) ;
	}
}
