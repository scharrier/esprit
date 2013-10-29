<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Match query.
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class Match extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'match' => [
				$this->in() => [
					'query' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
