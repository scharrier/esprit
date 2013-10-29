<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Regexp query.
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class Regexp extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'regexp' => [
				$this->in() => [
					'value' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
