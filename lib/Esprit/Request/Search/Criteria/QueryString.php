<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * QueryString query.
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
 */
class QueryString extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Force array.
	 *
	 * @param  mixed $in Where to search
	 * @return array     Where to search !
	 */
	public function in($in = null) {
		if (!isset($in)) {
			if ($this->data('in')) {
				return is_array($this->data('in')) ? $this->data('in') : [$this->data('in')] ;
			}
			return ['_all'] ;
		}

		return parent::in($in) ;
	}
	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'query_string' => [
				'query' => $this->value(),
				'fields' => $this->in()
			] + $this->properties()
		] ;
	}
}
