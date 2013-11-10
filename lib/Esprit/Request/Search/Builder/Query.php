<?php
namespace Esprit\Request\Search\Builder ;

use Esprit\Request\Search\Criteria\BoolMust ;

class Query extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		if (!$this->_children) {
			return [] ;
		}

		if (count($this->_children) === 1) {
			return $this->_children[0]->data() ;
 		}

 		$return = new BoolMust($this->_children) ;
		return $return->data() ;
	}
}
