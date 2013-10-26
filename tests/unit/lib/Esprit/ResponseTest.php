<?php
namespace Esprit\Test ;

class Response extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$response = new \Esprit\Response(array()) ;
		$this->assertTrue($response instanceof \Esprit\Response) ;
	}

	public function testSet() {
		$response = new \Esprit\Response(array()) ;
		$response->set('field','value') ;
		$this->assertEquals('value', $response->field) ;

		$response->set(array('field' => 'value2')) ;
		$this->assertEquals('value2', $response->field) ;
	}

	public function testAccessors() {
		$response = new \Esprit\Response(array(
			'ok' => true,
			'version' => array(
				'number' => '0.18.5'
			)
		)) ;
		$this->assertEquals(true, $response->ok);
		$this->assertTrue($response->version instanceof \Esprit\Response) ;
		$this->assertEquals('0.18.5', $response->version->number) ;
	}

	public function testException() {
		try {
			$response = new \Esprit\Response(array(
				'error' => 'My error message',
				'status' => 400
			)) ;
			$this->fail('No exception') ;
		} catch (\Esprit\Response\Exception $e) {
			$this->assertEquals(400, $e->status) ;
			$this->assertEquals('My error message', $e->error) ;
		}

		try {
			$response = new \Esprit\Response(array(
				'_shards' => array(
					'failed' => 2
				)
			)) ;
			$this->fail('No exception') ;
		} catch (\Esprit\Response\Exception $e) {
			$this->assertEquals('An error has occured on a shard during request parsing', $e->error) ;
		}

		try {
			$response = new \Esprit\Response(array(
				'_shards' => array(
					'failed' => 2,
					'failures' => array(
						array('reason' => 'Shard error')
					)
				)
			)) ;
			$this->fail('No exception') ;
		} catch (\Esprit\Response\Exception $e) {
			$this->assertEquals('Some errors have occured on a shard during request parsing : Shard error', $e->error) ;
		}
	}
}
