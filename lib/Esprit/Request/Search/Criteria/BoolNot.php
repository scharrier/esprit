<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Not criteria (filters only).
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-not-filter.html
 */
class BoolNot extends \Esprit\Request\Search\Criteria\Type\ParentCriteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'not' => [
				'filters' => $this->_subData()
			] + $this->_data
		] ;
	}
}
