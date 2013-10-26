<?php
namespace Esprit\Test\Request ;

class Definition extends \PHPUnit_Framework_TestCase {

	public function testDefinition() {
		try {
			$definition = new \Esprit\Request\Definition(array()) ;
			$this->fail('No exception') ;
		} catch (\Exception $e) {}

		$definition = new \Esprit\Request\Definition(array('method' => 'GET')) ;
		$this->assertEquals('GET', $definition->method()) ;
		$this->assertNull($definition->path()) ;

		$definition = new \Esprit\Request\Definition(array(
			'method' => \Esprit\Request::GET,
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
		$this->assertEquals(\Esprit\Request::GET, $definition->method()) ;

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

