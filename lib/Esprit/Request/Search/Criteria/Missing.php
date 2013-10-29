<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Missing criteria (filters only)
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-missing-filter.html
 */
class Missing extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Constructor : only one parameter (no $in)
	 *
	 * @param mixed $field  Field name or data array
	 * @param array  $data  Optionnal data
	 */
	public function __construct($field, array $data = array()) {
		return parent::__construct($field, null, $data) ;
	}

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'missing' => [
				'field' => $this->value()
			] + $this->properties()
		] ;
	}
}
