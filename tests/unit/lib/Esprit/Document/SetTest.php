<?php
namespace Esprit\Test ;

class Set extends \PHPUnit_Framework_TestCase {

	public function testConstruct() {
		$set = new \Esprit\Document\Set() ;
		$this->assertTrue($set instanceof \Esprit\Document\Set) ;

		try {
			$set = new \Esprit\Document\Set(array('something', 'bad')) ;
			$this->fail() ;
		} catch (\Exception $e) {
		}

		$set = new \Esprit\Document\Set(new \Esprit\Document(array('something' => 'good'))) ;
		$this->assertTrue($set instanceof \Esprit\Document\Set) ;
		$this->assertEquals(1, count($set)) ;

		$set = new \Esprit\Document\Set(array(new \Esprit\Document(array('something' => 'good')))) ;
		$this->assertTrue($set instanceof \Esprit\Document\Set) ;
		$this->assertEquals(1, count($set)) ;
	}

	public function testInterfaces() {
		// Traversable (IteratorAggregate)
		$set = new \Esprit\Document\Set() ;
		$set->set(array(
			array('firstname' => 'Jim'),
			array('firstname' => 'Ray'),
			array('firstname' => 'Robbie')
		));

		$test = array() ;
		foreach($set as $document) {
			$test[] = $document->firstname ;
		}
		$this->assertEquals(array('Jim','Ray','Robbie'), $test) ;

		// Countable
		$this->assertEquals(3, count($set)) ;
	}

	public function testCheck() {
		$data = array('Not','A','Set') ;
		$this->assertFalse(\Esprit\Document\Set::check($data)) ;

		$data = array(
			array('is' => 'A Esprit_Document'),
			array('is' => 'Another Esprit_Document')
		) ;
		$this->assertTrue(\Esprit\Document\Set::check($data)) ;
	}

	public function testTransformation() {
		$data = array(
			array('is' => 'A Esprit_Document', 'empty' => ''),
			array('is' => 'Another Esprit_Document', 'zero' => '0')
		) ;
		$set = new \Esprit\Document\Set($data) ;

		$res = $set->to('array') ;
		$this->assertEquals($data, $res) ;

		$res = $set->to('array', array('clean' => true)) ;
		$this->assertFalse(isset($res[0]['empty'])) ;
		$this->assertTrue($res[1]['zero'] === 0.0) ;

		$res = $set->to('json') ;
		$this->assertEquals(json_encode($data), $res) ;
	}

	public function testExtract() {
		$data = array(
			array('id' => 1, 'is' => 'A Esprit_Document', 'empty' => '', 'sub' => array('key' => 'value')),
			array('id' => 2, 'is' => 'Another Esprit_Document', 'zero' => '0')
		) ;
		$set = new \Esprit\Document\Set($data) ;

		$res = $set->combine('id','is') ;
		$this->assertEquals(array(
			1 => 'A Esprit_Document',
			2 => 'Another Esprit_Document'
		), $res) ;

		$res = $set->combine('id','sub.key') ;
		$this->assertEquals(array(
			1 => 'value',
			2 => null
		), $res) ;

		$res = $set->pluck('id') ;
		$this->assertEquals(array(1,2), $res) ;
	}

	public function testSource() {
		$data = array(
			array('_id' => 10)
		) ;
		$set = new \Esprit\Document\Set($data, array('source' => true)) ;
		$this->assertTrue($set->get(0)->properties() instanceof \Esprit\Document) ;
		$this->assertEquals(10, $set->get(0)->properties()->id) ;

		$set = new \Esprit\Document\Set($data, array('source' => false)) ;
		$this->assertFalse($set->get(0)->properties() instanceof \Esprit\Document) ;
	}

}
