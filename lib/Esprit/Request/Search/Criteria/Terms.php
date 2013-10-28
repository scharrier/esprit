<?php
namespace Esprit\Request\Search\Criteria ;

class Terms extends \Esprit\Request\Search\Criteria\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'terms' => [
				$this->in() => $this->value()
			] + $this->properties()
		] ;
	}
}
