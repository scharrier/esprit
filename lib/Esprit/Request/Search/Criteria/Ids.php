<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Ids query.
 *
 * Doc : http://www.elasticsearch.org/guide/en/elasticsearch/reference/current/query-dsl-ids-query.html
 */
class Ids extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Force value() to be an array.
	 *
	 * @param  mixed $value Setter : value
	 * @return mixed        Getter : value or this
	 */
	public function value($value = null) {
		if (!isset($value)) {
			$value = parent::value() ;
			return is_array($value) ? $value : array($value) ;
		}

		return parent::value($value) ;
	}

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'ids' => [
				$this->in() => [
					'values' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
