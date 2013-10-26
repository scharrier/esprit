<?php
namespace Esprit ;

/**
 * Factory : generates instances following the configured mapping.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 */
class Factory extends \Esprit\Base {

	/**
	 * Reflection cache.
	 *
	 * @var array
	 */
	protected $_reflection = array() ;


	/**
	 * Generates a new request.
	 *
	 * @param string	$alias		Request name
	 * @return \\Esprit\Request
	 */
	public function request($alias) {
		$params = func_get_args() ;
		array_shift($params) ;
		return $this->_new('Request\\' . $this->_class($alias), $params) ;
	}

	/**
	 * Generates a new response.
	 *
	 * @param string	$alias		Response name
	 * @return \\Esprit\Response
	 */
	public function response($alias = null) {
		$params = func_get_args() ;
		array_shift($params) ;
		return $this->_new('Response\\' . $this->_class($alias), $params) ;
	}

	/**
	 * Generates a new client.
	 *
	 * @param string	$alias		Driver name
	 * @return \Esprit_Transport
	 */
	public function transport($alias) {
		$params = func_get_args() ;
		$params = isset($params[1]) ? $params[1] : array() ;
		$params = array($params, $this) ;
		return $this->_new('Transport\\' . $this->_class($alias), $params) ;
	}

	/**
	 * Returns the default param of a request class. Used by Esprit\Transport when
	 * it gets a first param wich is not an array.
	 *
	 * @param string	$path		Class path
	 * @return string				Name of the first param
	 */
	public function defaultParam($request) {
		$properties = $this->_reflect($this->_prefix('\\Request\\' . $this->_class($request)))->getDefaultProperties() ;
		return isset($properties['_definition']['magic']) ? $properties['_definition']['magic'] : null ;
	}

	/**
	 * Generates a new object.
	 *
	 * @param string	$path		Path to load
	 * @param array		$params		Constructor params
	 * @return object
	 */
	protected function _new($path, $params) {
		return $this->_reflect($this->_prefix($path))->newInstanceArgs($params);
	}

	/**
	 * Classify a command name.
	 *
	 * @param  string $alias Alias
	 * @return string        Class name
	 */
	protected function _class($alias) {
		return ucfirst($alias) ;
	}

	/**
	 * Prefix a class with the global namespace.
	 *
	 * @param  string $class Class
	 * @return string        Prefixed class
	 */
	protected function _prefix($class) {
		return '\\Esprit\\' . ltrim($class, '\\') ;
	}

	/**
	 * Generates (or returns if it exists) a reflection class for
	 * the given classe name.
	 *
	 * @param string	$class		Class name
	 * @return \ReflectionClass		Reflection class
	 */
	protected function _reflect($class) {
		if (!isset($this->_reflection[$class])) {
			$this->_reflection[$class] = new \ReflectionClass($class) ;
		}
		return $this->_reflection[$class] ;
	}
}
