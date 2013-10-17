<?php
namespace Simples\Test ;

class Http extends \PHPUnit_Framework_TestCase {

    public function testConnection() {
		try {
			$transport = new \Simples\Transport\Http() ;
			$transport->connect() ;
			$this->assertTrue($transport->connected()) ;
			$this->assertTrue($transport instanceof \Simples\Transport\Http) ;

			$transport->disconnect() ;
			$this->assertFalse($transport->connected()) ;
		} catch (Exception $e) {
			$this->markTestSkipped($e->getMessage()) ;
		}

		try {
			$transport = new \Simples\Transport\Http(array('host' => 'www.google.com', 'port' => '80')) ;
			$transport->connect() ;
			$this->fail();
		} catch (Exception $e) {
		}


	}

	public function testCheck() {
		$transport = new \Simples\Transport\Http() ;

		$transport->config(array(
			'host' => 'www.google.com',
			'port' => 80
		)) ;

		try {
			$transport->connect() ;
		} catch(Exception $e) {
			return ;
		}

		$this->fail() ;
	}

	public function testUrl() {
		$transport = new \Simples\Transport\Http() ;
		$this->assertEquals('http://127.0.0.1/', $transport->url()) ;

		$transport->config('host', 'farhost') ;
		$this->assertEquals('http://farhost/', $transport->url()) ;

		$this->assertEquals('http://farhost/_status', $transport->url('_status')) ;
		$this->assertEquals('http://farhost/_status', $transport->url('/_status')) ;
	}

	public function testCall() {
		$transport = new \Simples\Transport\Http() ;
		$res = $transport->call() ;
		$this->assertTrue($res['ok']);
		$this->assertTrue(isset($res['version']['number'])) ;
	}

	public function testMagicCall() {
		$transport = new \Simples\Transport\Http() ;
		$status = $transport->status() ;
		$this->assertTrue($status instanceof \Simples\Request_Status) ;
		$response = $transport->status()->execute() ;
		$this->assertTrue($response instanceof Simples_Response) ;
	}
}
