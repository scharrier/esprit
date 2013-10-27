<?php
namespace Esprit ;

use \Esprit\Response\Exception ;

/**
 * Standard response class.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Reponse
 */
class Response {

	use \Esprit\Behavior\DataContainer ;
	use \Esprit\Behavior\Configurable ;

	/**
	 * Data
	 *
	 * @var array
	 */
	protected $_data = array() ;

	/**
	 * Config
	 *
	 * @var array
	 */
	protected $_config = array() ;

	/**
	 * Constructor.
	 *
	 * @param EspritTransport $transport		Connection to use.
	 */
	public function __construct(array $data, array $config = null) {
		$this->set($data) ;

		if (isset($config)) {
			$this->config($config) ;
		}
	}

	/**
	 * Set response data.
	 *
	 * @param array $data			Array of data
	 * @return \\Esprit\Response	Current response
	 */
	public function set($key = null, $data = null) {
		if (is_string($key)) {
			$this->_data[$key] = $data ;
		} else {
			$this->_check($key) ;
			$this->_data = $key ;
		}

		return $this ;
	}

	/**
	 * Check if response data is valid.
	 *
	 * @param array $data	Response data.
	 * @throws Exception
	 */
	protected function _check(array $data) {
		// Intercepted ES error
		if (isset($data['error'])) {
			throw new Exception($data) ;
		}
		// Shard failure
		if (!empty($data['_shards']['failed'])) {
			if (empty($data['_shards']['failures'])) {
				throw new Exception('An error has occured on a shard during request parsing') ;
			} else {
				$errors = array() ;
				foreach($data['_shards']['failures'] as $failure) {
					if (!empty($failure['reason'])) {
						$errors[] = $failure['reason'] ;
					}
				}
				throw new Exception('Some errors have occured on a shard during request parsing : ' . implode($errors)) ;
			}
		}
	}

	/**
	 * Get some data. If no passe is given, returns all the $this->_data array. If subdata for $path
	 * if an array, returns a news instance of self.
	 *
	 * @param string $path	Path we want to get
	 * @return mixed		The value, another instance or null.
	 */
	public function get($path = null) {
		// We want all our data back !
		if (!isset($path)) {
			return $this->_data ;
		}

		if (isset($this->_data[$path])) {
			if (is_array($this->_data[$path])) {
				return new self($this->_data[$path]) ;
			}
			return $this->_data[$path] ;
		}

		return null ;
	}

	/**
	 * Magic access. Gives the ability to call :
	 * $response->param->subparam
	 *
	 * @param string	$path	Path we want to get
	 * @return mixed			The value, another instance or null.
	 */
	public function __get($path) {
		return $this->get($path) ;
	}

	/**
	 * Check if a key is set in $this->_data.
	 *
	 * @param string	$path	Path to check
	 * @return bool				Yep, or nope.
	 */
	public function __isset($path) {
		return isset($this->_data[$path]) ;
	}
}
