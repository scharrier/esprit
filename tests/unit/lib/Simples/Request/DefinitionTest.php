<?php
namespace Simples\Test\Request ;

class Definition extends \PHPUnit_Framework_TestCase {

	public function testDefinition() {
		try {
			$definition = new \Simples\Request\Definition(array()) ;
			$this->fail('No exception') ;
		} catch (\Exception $e) {}

		$definition = new \Simples\Request\Definition(array('method' => 'GET')) ;
		$this->assertEquals('GET', $definition->method()) ;
		$this->assertNull($definition->path()) ;

		$definition = new \Simples\Request\Definition(array(
			'method' => \Simples\Request::GET,
			'required' => array(
				'body' => array('id')
			),
			'inject' => array(
				'directories' => array('index'),
				'params' => array('id')
			),
			'magic' => 'id'
		)) ;

		// Method
		$this->assertEquals(\Simples\Request::GET, $definition->method()) ;

		// Required params
		$this->assertEquals(array('id'), $definition->required('body')) ;
		$this->assertEquals(array(), $definition->required('options')) ;
		$this->assertEquals(array('body','options'), array_keys($definition->required())) ;

		// Params to inject
		$this->assertEquals(array('index'), $definition->inject('directories')) ;
		$this->assertEquals(array('id'), $definition->inject('params')) ;
		$this->assertEquals(array('directories','params'), array_keys($definition->inject())) ;

		// Magic param
		$this->assertEquals('id', $definition->magic()) ;
	}

}

