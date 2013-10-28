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
	 * Gt property accessor
	 *
	 * @param  mixed $gt Setter : value
	 * @return mixed      Getter : value
	 */
	public function gt($gt = null) {
		return $this->_setget('gt', $gt) ;
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
	 * Lt property accessor
	 *
	 * @param  mixed $lt Setter : value
	 * @return mixed      Getter : value
	 */
	public function lt($lt = null) {
		return $this->_setget('lt', $lt) ;
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
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		return [
			'range' => [
				$this->in() => $this->properties()
			]
		] ;
	}
}
