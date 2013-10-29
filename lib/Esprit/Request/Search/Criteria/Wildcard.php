<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Wildcard query.
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-wildcard-query.html
 */
class Wildcard extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'wildcard' => [
				$this->in() => [
					'value' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
