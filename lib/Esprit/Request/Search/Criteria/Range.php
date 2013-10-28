<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Range criteria
 */
class Range extends \Esprit\Request\Search\Criteria\Type\FieldValue {

	/**
	 * Constructor : handle simple call.
	 *
	 * @param mixed $in  Field value or data
	 * @param float $lte Minimum
	 * @param float $gte Maximum
	 */
	public function __construct($in = null, $lte = null, $gte = null) {
		if (isset($in)) {
			if (is_string($in)) {
				$this->data(['in' => $in, 'lte' => $lte, 'gte' => $gte]) ;
			} else {
				$this->data($in) ;
			}
		}
	}

	/**
	 * Gte property accessor
	 *
	 * @param  mixed $gte Setter : value
	 * @return mixed      Getter : value
	 */
	public function gte($gte = null) {
		return $this->_setget('gte', $gte) ;
	}

	/**
	 * Lte property accessor
	 *
	 * @param  mixed $lte Setter : value
	 * @return mixed      Getter : value
	 */
	public function lte($lte = null) {
		return $this->_setget('lte', $lte) ;
	}

	/**
	 * Get all criteria properties
	 *
	 * @return array Properties
	 */
	public function properties() {
		return array_diff_key($this->_data, array('in' => true, 'lte' => true, 'gte' => true)) ;
	}

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => [
					'gte' => $this->gte(),
					'lte' => $this->lte()
				] + $this->properties()
			]
		] ;
	}
}
