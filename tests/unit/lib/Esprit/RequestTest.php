<?php
namespace Esprit\Tests;

class Request extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$request = new \Esprit\Request\Custom() ;
		$this->assertTrue($request instanceof \Esprit\Request) ;
	}

	public function testDefinition() {
		$request = new \Esprit\Request\Custom() ;
		$this->assertTrue($request->definition() instanceof \Esprit\Request\Definition) ;
		$this->assertEquals('_status', $request->definition()->path()) ;
	}

	public function testPath() {
		$request = new \Esprit\Request\Custom() ;
		$this->assertEquals('/_status/', $request->path()) ;

	}

	public function testMethod() {
		$request = new \Esprit\Request\Custom() ;
		$this->assertEquals(\Esprit\Request::GET, $request->method()) ;

	}

	public function testExecute() {
		$request = new \Esprit\Request\Custom() ;
		$res = $request->execute() ;
		$this->assertTrue($request->execute() instanceof \Esprit\Response) ;

		$res = $request->client(new \Esprit\Transport\Http())->execute() ;
		$this->assertTrue($res->get('ok') === true) ;
	}

	public function testTo() {
		$request = new \Esprit\Request\Custom() ;
		$this->assertTrue(is_string($request->to('json'))) ;


		$request->body(array(
			'hey' => 'ho'
		)) ;
		$res = $request->to('array') ;
		$this->assertTrue(is_array($res)) ;
		$this->assertEquals('ho', $res['hey']) ;

		try {
			$request->to('somethingbad') ;
			$this->fail('No exception !') ;
		} catch (\Exception $e) {
		}
	}

	public function testIndicesTypes() {
		$request = new \Esprit\Request\Custom(null, array(
			'index' => 'twitter',
			'type' => 'tweet'
		)) ;
		$this->assertEquals('twitter', $request->index()) ;
		$this->assertEquals('tweet', $request->type()) ;

		$request->options(array('type' => array(
			'tweet','user'
		))) ;
		$this->assertEquals('tweet,user', $request->type()) ;

		$this->assertEquals('/twitter/tweet,user/_status/', (string) $request->path()) ;

	}
}

namespace Esprit\Request ;

class Custom extends \Esprit\Request {

	protected $_path = '/_status' ;

	protected $_method = \Esprit\Request::GET ;

	protected $_definition = array(
		'method' => \Esprit\Request::GET,
		'path' => '_status'
	) ;
}
