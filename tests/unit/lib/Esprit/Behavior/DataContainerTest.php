<?php
namespace Esprit\Behavior ;

class DataContainerTest extends \PHPUnit_Framework_TestCase {

	public function testData() {
		$object = $this->getObjectForTrait('\Esprit\Behavior\DataContainer') ;
		$object->data(array('hello' => 'world')) ;

		$this->assertEquals(['hello' => 'world'], $object->data()) ;
		$this->assertEquals(['hello' => 'world'], $object->to('array')) ;
		$this->assertEquals('{"hello":"world"}', $object->to('json')) ;

		$this->setExpectedException('\Exception');
		$object->to('somethingbad') ;

	}
}
