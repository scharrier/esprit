<?php
namespace Simples\Unit\Transport ;

class HttpTest extends \PHPUnit_Framework_TestCase {

	public function testUrl() {
		$transport = new \Simples\Transport\Http() ;
		$this->assertEquals('http://127.0.0.1/', $transport->url()) ;

		$transport->config('host', 'farhost') ;
		$this->assertEquals('http://farhost/', $transport->url()) ;

		$this->assertEquals('http://farhost/_status', $transport->url('_status')) ;
		$this->assertEquals('http://farhost/_status', $transport->url('/_status')) ;
	}

	public function testMagicCall() {
		$transport = new \Simples\Transport\Http() ;
		$status = $transport->status() ;
		$this->assertTrue($status instanceof \Simples\Request\Status) ;
	}
}
