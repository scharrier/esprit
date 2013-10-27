<?php
namespace Esprit\Behavior ;

/**
 * Data container : gives ability to objects to set/get data and transform it
 * in any format if the method is supported.
 */
trait DataContainer {

	/**
	 * Object data.
	 *
	 * @var array
	 */
	protected $_data = array() ;

	/**
	 * Wrapper for format transformation : gives the request in the asked
	 * format.
	 *
	 * Actually supported : array, json
	 *
	 * @param string	$format		Asked format
	 * @return mixed				Formated request
	 */
	public function to($format, array $options = array()) {
		$method =  '_to' . ucfirst($format) ;
		if (method_exists($this, $method)) {
			return $this->{$method}($this->_data($options), $options) ;
		}

		throw new \Exception('Unsupported transformation format : "' . $format . '"') ;
	}

	/**
	 * Data getter/setter.
	 *
	 * @param  array $data Setter : data to set
	 * @return array       Getter : data to get
	 */
	public function data($data = null) {
		if (!isset($data)) {
			return $this->_data() ;
		}

		$this->_data = $data ;
	}

	/**
	 * Base data getter.
	 *
	 * @return array
	 */
	protected function _data(array $options = array()) {
		if (isset($this->_data)) {
			return $this->_data ;
		}
		return array() ;
	}

	/**
	 * Json transformation
	 *
	 * @return string	Request in json
	 */
	protected function _toJson($data, array $options = array()) {
		return !empty($data) ? json_encode($data) : '' ;
	}

	/**
	 * Array transformation
	 *
	 * @return array
	 */
	protected function _toArray($data, array $options = array()) {
		return $data ;
	}
}