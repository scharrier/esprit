<?php
namespace Simples\Tests;

class Transport extends \PHPUnit_Framework_TestCase {

	public function testMagic() {
		// Defaults index / type
		$client = new \Simples\Transport\Fake(array(
			'index' => 'twitter',
			'type' => 'tweet'
		)) ;

		$request = $client->get(array('id' => 1)) ;
		$body = $request->body() ;
		$this->assertEquals('twitter',$request->index()) ;
		$this->assertEquals('tweet',$request->type()) ;

		$client->config('index', 'facebook') ;
		$request = $client->get(array('id' => 2)) ;
		$body = $request->body() ;
		$this->assertEquals('facebook',$request->index()) ;

		// Magic params
		$request = $client->get(666) ;
		$body = $request->body() ;
		$this->assertEquals('facebook',$request->index()) ;
		$this->assertEquals('tweet',$request->type()) ;
		$this->assertEquals(666,$body['id']) ;

		try {
			$client->stats('ouch') ;
			$this->fail() ;
		} catch (\Exception $e) {
			return ;
		}
	}

	public function testLog() {
		$client = new \Simples\Transport\Fake() ;
		$client->call('/some/action',\Simples\Request::GET) ;
		$client->call('/other/action',\Simples\Request::PUT, array('some' => 'data')) ;
		$this->assertEquals(2, count($client->logs())) ;
		$expected =
'GET : /some/action
PUT : /other/action > {"some":"data"}
' ;
		$this->assertEquals($expected, $client->logs(true)) ;
	}
}

namespace Simples\Transport ;

class Fake extends \Simples\Transport {

	protected $_connected ;

	public function connect() {
		$this->_connected = true ;
		return $this ;
	}

	public function disconnect() {
		$this->_connected = false ;
		return $this ;
	}

	public function connected() {
		return $this->_connected ;
	}

	public function call($path = null, $method = 'GET', $data = null) {
		$this->log($path, $method, $data) ;
		return new \Simples\Response(array()) ;
	}
}
