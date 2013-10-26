<?php
namespace Esprit\Request\Search ;

/**
 * Search query builder.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request.Search
 */
abstract class Builder extends \Esprit\Base implements \Countable {

	/**
	 * Request dependency.
	 *
	 * @var \Esprit\Request_Search
	 */
	protected $_request ;

	/**
	 * Constructor.
	 *
	 * @param mixed						$query		Query definition (string/array)
	 * @param \Esprit\Request_Search	$request	Request calling this query builder.
	 */
	public function __construct(\Esprit\Request\Search $request = null) {
		if (isset($request)) {
			$this->_request = $request ;
		}
	}

	/**
	 * Default instance return : $this. Overriden in most builders.
	 *
	 * @return \Esprit\Request_Search_Builder this builder
	 */
	public function instance() {
		return $this ;
	}

	/**
	 * Add an element to the current builder.
	 *
	 * @param mixed		$criteria	Element to add.
	 * @return mixed				Current builder instance or current request instance (fluid calls)
	 */
	abstract public function add($element, array $options = array()) ;


	/**
	 * Fluid interface : returns the request instance if set, or this instance.
	 *
	 * @return \Esprit_Base
	 */
	protected function _fluid() {
		if (isset($this->_request)) {
			return $this->_request ;
		}
		return $this ;
	}
}
