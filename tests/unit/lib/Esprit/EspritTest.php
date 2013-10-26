<?php
namespace Esprit ;

class EspritTest extends \PHPUnit_Framework_TestCase {

	public function testStaticUsage() {
		$client = Esprit::connect(array(
			'host' => '127.0.0.1',
		)) ;
		$this->assertTrue(Esprit::connected()) ;
		$this->assertTrue($client->connected()) ;

		Esprit::disconnect() ;
		$this->assertFalse(Esprit::connected()) ;

		$client = Esprit::connect() ;
		$this->assertEquals('127.0.0.1', $client->config('host')) ;
		$this->assertEquals(true, Esprit::current()->status()->ok) ;

		Esprit::current()->config(array(
			'index' => 'twitter',
			'type' => 'tweet'
		));

		Esprit::current()->index(
			array(
				'from' => 'Static usage'
			),
			array(
				'id' => 1,
				'refresh' => true
			)
		)->execute() ;

		$this->assertEquals('Static usage', Esprit::current()->get(array(
			'id' => 1
		))->_source->from) ;
	}

	public function testMultiConnect() {
		Esprit::connect(array(
			'host' => '127.0.0.1',
			'index' => 'stars'
		)) ;
		Esprit::connect(array(
			'host' => '127.0.0.1',
			'index' => 'planets'
		)) ;
		$this->assertEquals('planets', Esprit::current()->config('index')) ;
	}

	public function testClient() {
		$client = Esprit::client(array('host' => 'something')) ;
		$other = Esprit::client(array('host' => 'somethingelse')) ;
		$this->assertTrue($client->config('host') !== $other->config('host')) ;
	}
}
