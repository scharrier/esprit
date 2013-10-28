<?php
namespace Esprit\Request\Search\Criteria ;

class Field extends \Esprit\Request\Search\Criteria\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'field' => [
				$this->in() => [
					'query' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
