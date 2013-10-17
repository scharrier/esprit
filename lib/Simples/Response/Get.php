<?php
namespace Simples\Response ;

use \Simples\Document ;
use \Simples\document\Set ;

/**
 * Specific get response.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Response
 */
class Get extends \Simples\Response {

	/**
	 * Constructor overriden : do highlight work.
	 *
	 * @param array $data		Response data.
	 * @param array $config		Response options.
	 */
	public function __construct(array $data, array $config = null) {
		parent::__construct($data, $config);

		if ($this->config('highlight') === \Simples\Request\Search::HIGHLIGHT_REPLACE)  {
			$this->set($this->_replaceHighlights($data)) ;
		}
	}

	/**
	 * Returns a Document instance.
	 *
	 * @return Simples_Document Current object
	 */
	public function document() {
		if (isset($this->_data['_source'])) {
			return new Document($this->_data, array('source' => true)) ;
		}
		return null ;
	}

	/**
	 * Returns a Document set (mget call)
	 *
	 * @return Simples_Document_Set All documents
	 */
	public function documents() {
		if (isset($this->_data['docs'])) {
			return new Set($this->_data['docs'], array('source' => true)) ;
		}
		return null ;
	}

}
