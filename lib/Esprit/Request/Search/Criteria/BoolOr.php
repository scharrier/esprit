<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Or criteria (filters only).
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-or-filter.html
 */
class BoolOr extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'or' => [
				'filters' => $this->_subData()
			] + $this->_data
		] ;
	}
}
