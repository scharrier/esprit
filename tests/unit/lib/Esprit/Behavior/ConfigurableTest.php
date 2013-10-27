<?php
namespace Esprit\Behavior ;

class ConfigurableTest extends \PHPUnit_Framework_TestCase {

	public function testConfigure() {
		$object = $this->getObjectForTrait('\Esprit\Behavior\Configurable') ;

		$object->config(['key' => 'value']) ;
		$this->assertEquals('value', $object->config('key')) ;

		$config = ['key' => 'value_2', 'other_key' => 'other_value'] ;
		$object->config($config) ;
		$this->assertEquals('value_2', $object->config('key')) ;
		$this->assertEquals($config, $object->config()) ;
	}
}
