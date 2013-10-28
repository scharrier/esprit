<?php
namespace Esprit\Request\Search\Criteria\Type ;

/**
 * Generic class for all simple field/value criterias.
 */
abstract class FieldValue extends \Esprit\Request\Search\Criteria {

	/**
	 * Constructor : can directly take a field/value couple.
	 *
	 * @param mixed $in    In : field name or data array
	 * @param mixed $value Search value
	 */
	public function __construct($in = null, $value = null) {
		// Simpl instanciation
		if (isset($in)) {
			if (is_string($in)) {
				$this->data(['in' => $in, 'value' => $value]) ;
			} else {
				parent::__construct($in) ;
			}
		}
	}

	/**
	 * Get all criteria property but 'in' and 'value' properties.
	 *
	 * @return array Properties
	 */
	public function properties() {
		$properties = $this->_data ;

		return array_diff_key($properties, array('in' => true, 'value' => true)) ;
	}

	/**
	 * Fields localisation.
	 *
	 * @param  mixed $in Field(s) where we want to search
	 * @return mixed     Field(s)
	 */
	public function in($in = null) {
		if (!isset($in)) {
			return $this->data('in') ;
		}
		return $this->data('in', $in) ;
	}

	/**
	 * Value.
	 *
	 * @param  mixed $value Value
	 * @return mixed        Value
	 */
	public function value($value = null) {
		if (!isset($value)) {
			return $this->data('value') ;
		}
		return $this->data('value', $value) ;
	}
}
