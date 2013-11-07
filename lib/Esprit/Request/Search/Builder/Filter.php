<?php
namespace Esprit\Request\Search\Builder ;

class Filter extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return $this->_subData() ;
	}
}
