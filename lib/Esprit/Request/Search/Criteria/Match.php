<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Match or multimatch query.
 *
 * Doc :
 * - Match : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 * - Multi match : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-multi-match-query.html
 */
class Match extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		if (is_array($this->in())) {
			// Multi match (multiple fields)
			return [
				'multi_match' => [
					'query' => $this->value(),
					'fields' => $this->in()
				] + $this->properties()
			] ;
		}

		// Standard match
		return [
			'match' => [
				$this->in() => [
					'query' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
