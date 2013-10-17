<?php
namespace Simples\Request ;

use \Simples\Document ;

/**
 * Update.
 *
 * Updates an object in the index/type defined.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Request
 */
class Update extends Index {

	/**
	 * Bulk action.
	 *
	 * @var string
	 */
	protected $_action = 'update' ;

	/**
	 * Path : add the "_update" action when not in bulk mode.
	 *
	 * @return string	API path
	 */
	public function path() {
		$path = parent::path() ;
		if (!$this->bulk()) {
			$path->directory('_update') ;
		}

		return $path ;
	}

	/**
	 * Returns the doc in json inside a "doc" instruction.
	 *
	 * @param  Simples_Document $document Doc to index
	 * @return string                     Json string
	 */
	protected function _jsonDoc(Document $document, array $options = array()) {
		$return =  array('doc' => $document->to('array', $options + $this->_options)) ;
		return json_encode($return) ;
	}
}
