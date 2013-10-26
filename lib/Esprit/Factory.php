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
	 * Current mapping.
	 *
	 * @var array
	 */
	protected $_mapping = array() ;

	/**
	 * Reflection cache.
	 *
	 * @var array
	 */
	protected $_reflection = array() ;

	/**
	 * Base mapping.
	 *
	 * @var array
	 */
	static protected $_baseMapping = array(
		'Request' => array(
			'status' => '\Esprit\Request\Status',
			'stats' => '\Esprit\Request\Stats',
			'index' => '\Esprit\Request\Index',
			'update' => '\Esprit\Request\Update',
			'get' => '\Esprit\Request\Get',
			'delete' => '\Esprit\Request\Delete',
			'search' => '\Esprit\Request\Search',
			'mapping' => '\Esprit\Request\Mapping',
			'createIndex' => '\Esprit\Request\CreateIndex',
			'deleteIndex' => '\Esprit\Request\DeleteIndex',
			'createType' => '\Esprit\Request\CreateType',
			'deleteType' => '\Esprit\Request\DeleteType'
		),
		'Response' => array(
		),
		'Transport' => array(
			'http' => '\Esprit\Transport\Http'
		)
	) ;

	/**
	 * Constructor. Initialize the default mapping.
	 */
	public function __construct() {
		$this->map(self::$_baseMapping) ;
	}

	/**
	 * Merge some new mappings with the current loaded mappings. You have
	 * to use the relative namespaces to Esprit. Ex : Request.status .
	 *
	 * You can give an array with multiples mappings, or update mapping for one
	 * alias.
	 *
	 * Note that if your custom mappings cannot be loaded automagically with
	 * the Autoload.php processus, you have ton require it manually.
	 *
	 * Examples of usage :
	 * $factory->map('Request.status','\Esprit\Request\MyCustomStatus');
	 * $factory->map('Request', array(...));
	 * $factory->map(array(
	 *		'Request' => array(
	 *			'status' => 'OtherCustomStatus',
	 *			'search' => 'MyFuckinGreatSearchRequestClass'
	 *		),
	 *		'Transport' => array(
	 *			'memcache' => 'ArghNotYetImplemented'
	 *		)
	 * ));
	 *
	 * @param mixed		$path				Array of data or path
	 * @param string	$classes			Classes to map
	 * @throws Esprit_Factory_Exception
	 */
	public function map($path, $classes = null) {
		if (is_array($path)) {
			$classes = $path ;
		} else {
			if (strpos($path, '.') !== false) {
				$path = explode('.', $path) ;
				if (!isset(self::$_baseMapping[$path[0]])) {
					throw new \Esprit\Factory\Exception('Bad namespace level "' . $path[0] . '"') ;
				}
				$classes = array(
					$path[0] => array(
						$path[1] => $classes
					)
				) ;
			} else {
				$classes = array(
					$path => $classes
				) ;
			}
		}

		foreach($classes as $level => $aliases) {
			foreach($aliases as $alias => $class) {
				$this->_mapping[$level . '.' . $alias] = $class ;
			}
		}
	}

	/**
	 * Gets the mapping : everything or just for $path.
	 * Note : $path has to be the exact pass (Request.* nor supported).
	 *
	 * @param string	$path		[Optionnal]
	 * @return mixed				All the mapping (array) or the classe name (string)
	 * @throws Esprit_Factory_Exception
	 */
	public function mapping($path = null) {
		if (!isset($path)) {
			return $this->_mapping ;
		}
		if (!isset($this->_mapping[$path])) {
			throw new \Esprit\Factory\Exception('Bad namespace "' . $path . '"') ;
		}
		return $this->_mapping[$path] ;
	}

	/**
	 * Check if a path is a valid namespace.
	 *
	 * @param string $path		Path to check
	 * @return bool
	 */
	public function valid($path) {
		return isset($this->_mapping[$path]) ;
	}

	/**
	 * Generates a new request.
	 *
	 * @param string	$alias		Request name
	 * @return \\Esprit\Request
	 */
	public function request($alias) {
		$params = func_get_args() ;
		array_shift($params) ;
		return $this->_new('Request.' . $alias, $params) ;
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
		return $this->_new('Response.' . $alias, $params) ;
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
		return $this->_new('Transport.' . $alias, $params) ;
	}

	/**
	 * Returns the default param of a class. Used by Esprit_Transport when
	 * it gets a first param wich is not an array.
	 *
	 * @param string	$path		Class path
	 * @return string				Name of the first param
	 */
	public function defaultParam($path) {
		$class = $this->mapping($path) ;
		$properties = $this->_reflect($class)->getDefaultProperties() ;
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
		$class = $this->mapping($path) ;

		return $this->_reflect($class)->newInstanceArgs($params);
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
