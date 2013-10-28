<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Lte (range with lte only) criteria
 */
class Lte extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => [
					'lte' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
