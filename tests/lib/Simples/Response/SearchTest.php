<?php
namespace Simples\Test\Response ;

class Search extends \PHPUnit_Framework_TestCase {

	public function testHighlight() {
		$response = new \Simples\Response\Search(array(
			'hits' => array(
				'hits' => array(
					array(
						'_source' => array(
							'Utilisateur' => array(
								'name' => 'Sebastien'
							)
						),
						'highlight' => array(
							'Utilisateur.name' => '<em>Sebastien<em>'
						)
					)
				)
			)
		), array('highlight' => \Simples\Request\Search::HIGHLIGHT_REPLACE)) ;

		$this->assertEquals('<em>Sebastien<em>', $response->hits->hits->{0}->_source->Utilisateur->name) ;

		// Special ES case : highlight returned as an array
		$response = new \Simples\Response\Search(array(
			'hits' => array(
				'hits' => array(
					array(
						'_source' => array(
							'Utilisateur' => array(
								'name' => 'Sebastien'
							)
						),
						'highlight' => array(
							'Utilisateur.name' => array('<em>Sebastien<em>')
						)
					)
				)
			)
		), array('highlight' => \Simples\Request\Search::HIGHLIGHT_REPLACE)) ;

		$this->assertEquals('<em>Sebastien<em>', $response->hits->hits->{0}->_source->Utilisateur->name) ;

		// special case for subarray formated data
		$response = new \Simples\Response\Search(array(
			'hits' => array(
				'hits' => array(
					array(
						'_source' => array(
							'Utilisateur' => array(
								0 => array(
									'name' => array(0 => 'Sebastien')
								)
							)
						),
						'highlight' => array(
							'Utilisateur.name' => array('<em>Sebastien<em>')
						)
					)
				)
			)
		), array('highlight' => \Simples\Request\Search::HIGHLIGHT_REPLACE)) ;

		$this->assertEquals('<em>Sebastien<em>', $response->hits->hits->{0}->_source->Utilisateur->{0}->name->{0}) ;

	}

	public function testHits() {
		$response = new \Simples\Response\Search(array(
			'hits' => array(
				'hits' => array(
					array(
						'_source' => array(
							'Utilisateur' => array(
								'name' => 'Jim Morrison'
							)
						)
					),
					array(
						'_source' => array(
							'Utilisateur' => array(
								'name' => 'Ray Manzareck'
							)
						)
					)
				)
			)
		));

		$this->assertEquals(2, count($response->hits())) ;

		$test = array() ;
		foreach($response->hits() as $document) {
			$test[] = $document->Utilisateur->name ;
		}

		$expected = array('Jim Morrison', 'Ray Manzareck') ;
		$this->assertEquals($expected, $test) ;
	}
}
