<?php
namespace Esprit\Request\Search\Criteria ;

class Term extends \Esprit\Request\Search\Criteria {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'term' => [
				$this->in() => [
					'value' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
