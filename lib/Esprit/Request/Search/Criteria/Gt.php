<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Gt (range with Gt only) criteria
 */
class Gt extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => [
					'gt' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
