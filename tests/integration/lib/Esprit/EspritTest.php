<?php
namespace Esprit\Integration ;

use \Esprit\Esprit ;
use \Esprit\Request\Builder as ES ;

class EspritTest extends \PHPUnit_Framework_TestCase {

	public function testConnect() {
		// Esprit::current()->search()
		// 	->query('coucou')
		// 	->sort('created')
		// 	->limit(10) ;

		// Esprit::current()->search()
		// 	->query(
		// 		ES::fuzzy('coucou')->in('field'),
		// 		ES::fulltext('seb'))
		// 	->sort('created')
		// 	->limit(10) ;

		// Esprit::current()->search()
		// 	->query(
		// 		ES::or(
		// 			ES::fuzzy('coucou')->in('field'),
		// 			ES::fulltext('seb')
		// 			ES::and(
		// 				ES::range(['from' => 10, 'to' => 100]),
		// 				ES::match('*wesh*')->in(['first','second'])
		// 			)
		// 		))
		// 	->facets(
		// 		ES::facet('field'),
		// 		ES::facet(['name' => 'name', 'type' => 'tutu'])->filter(
		// 			ES::gt('field',10),
		// 			ES::or(
		// 				ES::lt('field',2),
		// 				ES::range())
		// 		)

	}
}
