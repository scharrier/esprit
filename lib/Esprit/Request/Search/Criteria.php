<?php
namespace Esprit\Request\Search ;

abstract class Criteria {

	use \Esprit\Behavior\DataContainer ;

	/**
	 * Criteria data.
	 *
	 * @var array
	 */
	protected $_data = array() ;

	/**
	 * Constructor.
	 *
	 * @param mixed $data Criteria data or magic params.
	 */
	public function __construct($data = null) {
		if (isset($data) && is_array($data)) {
			$this->data($data) ;
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
