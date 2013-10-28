<?php
namespace Esprit\Request\Search ;

/**
 * Query builder.
 */
class Builder {

	/**
	 * Reflection classes (for performances)
	 *
	 * @var array
	 */
	static protected $_reflection = array() ;

	/**
	 * Static method doesn't exists : we try to instanciate.
	 *
	 * @param  string $class                     Class name
	 * @param  array $args                       Arguments
	 * @return \Esprit\Request\Search\Criteria   Search criteria if found
	 */
	static public function __callStatic($class, $args) {
		$class = '\Esprit\Request\Search\Criteria\\' . ucfirst($class) ;
		if (class_exists($class)) {
			return static::_reflect($class)->newInstanceArgs($args);
		}
	}

	/**
	 * Generates (or returns if it exists) a reflection class for
	 * the given classe name.
	 *
	 * @param string	$class		Class name
	 * @return \ReflectionClass		Reflection class
	 */
	static protected function _reflect($class) {
		if (!isset(static::$_reflection[$class])) {
			static::$_reflection[$class] = new \ReflectionClass($class) ;
		}
		return static::$_reflection[$class] ;
	}
}
