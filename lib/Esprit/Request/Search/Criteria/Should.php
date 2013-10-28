<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Should criteria.
 */
class Should extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'bool' => [
				'should' => $this->_subData()
			] + $this->_data
		] ;
	}
}
