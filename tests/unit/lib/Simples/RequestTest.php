<?php
namespace Simples\Tests;

class Request extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$request = new \Simples\Request\Custom() ;
		$this->assertTrue($request instanceof \Simples\Request) ;
	}

	public function testDefinition() {
		$request = new \Simples\Request\Custom() ;
		$this->assertTrue($request->definition() instanceof \Simples\Request\Definition) ;
		$this->assertEquals('_status', $request->definition()->path()) ;
	}

	public function testPath() {
		$request = new \Simples\Request\Custom() ;
		$this->assertEquals('/_status/', $request->path()) ;

	}

	public function testMethod() {
		$request = new \Simples\Request\Custom() ;
		$this->assertEquals(\Simples\Request::GET, $request->method()) ;

	}

	public function testExecute() {
		$request = new \Simples\Request\Custom() ;
		$res = $request->execute() ;
		$this->assertTrue($request->execute() instanceof \Simples\Response) ;

		$res = $request->client(new \Simples\Transport\Http())->execute() ;
		$this->assertTrue($res->get('ok') === true) ;
	}

	public function testTo() {
		$request = new \Simples\Request\Custom() ;
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
		$request = new \Simples\Request\Custom(null, array(
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

namespace Simples\Request ;

class Custom extends \Simples\Request {

	protected $_path = '/_status' ;

	protected $_method = \Simples\Request::GET ;

	protected $_definition = array(
		'method' => \Simples\Request::GET,
		'path' => '_status'
	) ;
}
