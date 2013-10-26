<?php
namespace Esprit\Response ;

use \Esprit\Document ;
use \Esprit\document\Set ;

/**
 * Specific get response.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Response
 */
class Get extends \Esprit\Response {

	/**
	 * Constructor overriden : do highlight work.
	 *
	 * @param array $data		Response data.
	 * @param array $config		Response options.
	 */
	public function __construct(array $data, array $config = null) {
		parent::__construct($data, $config);

		if ($this->config('highlight') === \Esprit\Request\Search::HIGHLIGHT_REPLACE)  {
			$this->set($this->_replaceHighlights($data)) ;
		}
	}

	/**
	 * Returns a Document instance.
	 *
	 * @return Esprit_Document Current object
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
	 * @return Esprit_Document_Set All documents
	 */
	public function documents() {
		if (isset($this->_data['docs'])) {
			return new Set($this->_data['docs'], array('source' => true)) ;
		}
		return null ;
	}

}
