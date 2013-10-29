<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * And criteria (filters only).
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-and-filter.html
 */
class BoolAnd extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'and' => [
				'filters' => $this->_subData()
			] + $this->_data
		] ;
	}
}
