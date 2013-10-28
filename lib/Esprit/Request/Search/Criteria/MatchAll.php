<?php
namespace Esprit\Request\Search\Criteria ;

class MatchAll extends \Esprit\Request\Search\Criteria {

	/**
	 * Body : always the same for a match_all criteria.
	 *
	 * @return array Body
	 */
	protected function _data() {
		return array('match_all' => new \stdClass()) ;
	}
}
