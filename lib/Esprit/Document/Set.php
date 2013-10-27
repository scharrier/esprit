<?php
namespace Esprit\Document ;

use \Esprit\Document ;
use \Esprit\Document\Exception ;

/**
 * Set of Elasticsearch documents.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Document
 */
class Set implements \IteratorAggregate, \Countable {

	use \Esprit\Behavior\DataContainer ;
	use \Esprit\Behavior\Configurable ;

	/**
	 * Configuration.
	 *
	 * @var array
	 */
	protected $_config = array(
		'source' => null
	) ;

	/**
	 * Constructor.
	 *
	 * @param array $set	Set of documents
	 */
	public function __construct($set = null, array $options = null) {
		if (isset($options)) {
			$this->config($options) ;
		}
		if (isset($set)) {
			$this->set($set) ;
		}
	}

	/**
	 * Sets the documents.
	 *
	 * @param array $set		Set of documents.
	 * @throws Document_Exception
	 */
	public function set($set) {
		if (!self::check($set)) {
			throw new Exception('$set is not a valid Document_Set set of documents') ;
		}
		if ($set instanceof Document) {
			$this->_data[] = $set ;
		} else {
			foreach($set as $document) {
				if ($document instanceof Document) {
					$this->_data[] = $document ;
				} else {
					$this->_data[] = new Document($document, $this->config()) ;
				}
			}
		}

		return $this ;
	}

	/**
	 * Get an element from the set.
	 *
	 * @param  int $position 		Element position
	 * @return Document     Element, if exists (null if not)
	 */
	public function get($position) {
		return (isset($this->_data[$position])) ? $this->_data[$position] : null ;
	}

	/**
	 * IteratorAggregate implementation.
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator() {
		return new \ArrayIterator($this->_data) ;
	}

	/**
	 * Countable implementation : counts the documents.
	 *
	 * @return int	Docs count.
	 */
	public function count() {
		return count($this->_data) ;
	}

	/**
	 * Extract some values from the documents of the set.
	 *
	 * @param  string $path Path of the data to extract
	 * @return array        Array of data
	 */
	public function pluck($path) {
		$values = array() ;
		foreach($this->_data as $doc) {
			$values[] = $doc->get($path) ;
		}
		return $values ;
	}

	/**
	 * Combine keys and values from the set into an key=>value hash.
	 *
	 * @param  string $key_path   Key extraction path
	 * @param  string $value_path Value extraction path
	 * @return array              Combined array
	 */
	public function combine($key_path, $value_path) {
		$combined = array() ;
		foreach($this->_data as $doc) {
			$combined[$doc->get($key_path)] = $doc->get($value_path) ;
		}
		return $combined ;
	}

	/**
	 * Static callable : check if data can be a Document_Set.
	 *
	 * @param mixed		$data		Data to test.
	 * @return boolean
	 */
	static public function check($data) {
		if ($data instanceof Document) {
			return true ;
		}
		if (!is_array($data)) {
			return false ;
		}
		foreach($data as $key => $value) {
			if (!is_numeric($key)) {
				return false ;
			}
			if (!is_array($value) && !$value instanceof Document) {
				return false ;
			}
		}
		return true ;
	}

	/**
	 * Array transformation.
	 *
	 * @return array	Array structured docs.
	 */
	protected function _toArray($data, array $options = array()) {
		$return = array() ;
		foreach($data as $doc) {
			$return[] = $doc->to('array', $options) ;
		}
		return $return ;
	}

	/**
	 * Json transformation.
	 *
	 * @return string	Json structured docs.
	 */
	protected function _toJson($data, array $options = array()) {
		$return = array() ;
		foreach($data as $doc) {
			$return[] = $doc->to('array', $options) ;
		}
		return json_encode($return);
	}
}
