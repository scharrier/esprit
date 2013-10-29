<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * MustNot criteria.
 */
class BoolMustNot extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'bool' => [
				'must_not' => $this->_subData()
			] + $this->_data
		] ;
	}
}
