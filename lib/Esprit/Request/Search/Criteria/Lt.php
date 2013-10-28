<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Lt (range with Lt only) criteria
 */
class Lt extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => [
					'lt' => $this->value()
				] + $this->properties()
			]
		] ;
	}
}
