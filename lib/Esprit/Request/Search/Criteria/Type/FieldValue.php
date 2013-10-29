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
	public function __construct($value = null, $in = null, array $data = array()) {
		// Simple instanciation
		if (isset($value)) {
			// Value or global data
			if ($this->_property($value)) {
				$this->data('value', $value) ;
			} else {
				parent::__construct($value) ;
			}

			// In
			if (isset($in)) {
				$this->data('in', $in) ;
			}

			// Optionnal data
			if ($data) {
				$this->data($data) ;
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
		return $this->_setget('in', $in) ;
	}

	/**
	 * Value.
	 *
	 * @param  mixed $value Value
	 * @return mixed        Value
	 */
	public function value($value = null) {
		return $this->_setget('value', $value) ;
	}

	/**
	 * Check if data is a single property or a global data array.
	 *
	 * @param  mixed $value Value to check
	 * @return bool         Test result
	 */
	protected function _property($value) {
		if (is_scalar($value)) {
			return true ;
		}
		if (is_array($value) && is_numeric(key($value))) {
			return true ;
		}

		return false ;
	}
}
