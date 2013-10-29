<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Must criteria.
 */
class BoolMust extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'bool' => [
				'must' => $this->_subData()
			] + $this->_data
		] ;
	}
}
