<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Gte (range with Gte only) criteria
 */
class Gte extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => [
					'gte' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
