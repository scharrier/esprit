<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Exact helper : switch from term to terms if needed.
 *
 * Doc :
 * - Term : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 * - Terms : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 */
class Exact extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		if (is_array($this->value())) {
			$return = new Terms($this->value(), $this->in(), $this->properties()) ;
		} else {
			$return = new Term($this->value(), $this->in(), $this->properties()) ;
		}

		return $return->to('array') ;
	}
}
