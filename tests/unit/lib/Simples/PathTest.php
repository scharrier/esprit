<?php
namespace Simples\Test ;

class Path extends \PHPUnit_Framework_TestCase {

	public function testPath() {
		$path = new \Simples\Path('/root/') ;
		$this->assertEquals('/root/', (string) $path) ;

		$path->directory('sub') ;
		$this->assertEquals('/root/sub/', (string) $path) ;

		$path->param('param','value') ;
		$this->assertEquals('/root/sub/?param=value', (string) $path) ;

		$path->params(array('other'=>'value')) ;
		$this->assertEquals('/root/sub/?param=value&other=value', (string) $path) ;

		$path->directories(array('other','again')) ;
		$this->assertEquals('/root/sub/other/again/?param=value&other=value', (string) $path) ;
	}
}
