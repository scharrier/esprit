<?php
namespace Esprit\Request ;

/**
 * Get.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request
 */
class Get extends \Esprit\Request {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::GET,
		'magic' => 'id',
		'required' => array(
			'body' => array('id'),
			'options' => array('index', 'type')
		)
	) ;

	protected $_body = array(
		'index' => null,
		'type' => null,
		'id' => null
	);

	protected $_multiple = false ;

	/**
	 * Overrides body for bulk indexing.
	 *
	 * @param mixed		$body	Data to index.
	 * @return mixed			Data to index.
	 */
	public function body($body = null) {
		if (is_array($body) && is_numeric(key($body))) {
			$this->_multiple = true ;
			$this->_body = $body ;
			return $this ;
		} elseif (isset($body)) {
			return parent::body($body) ;
		}

		if ($this->multiple()) {
			$return = array(
				'docs' => array()
			) ;
			foreach($this->_body as $id) {
				$return['docs'][] = array('_index' => $this->_options['index'], '_type' => $this->_options['type'], '_id' => $id) ;
			}
			return $return ;
		}
		return parent::body() ;
	}

	/**
	 * Test if the request is in multiple mode.
	 *
	 * @return bool
	 */
	public function multiple() {
		return $this->_multiple ;
	}

	/**
	 * Path : id management.
	 *
	 * @return string	API path
	 */
	public function path() {
		if ($this->multiple()) {
			$path = new \Esprit\Path('_mget') ;
			if ($this->definition()->inject('params')) {
				$path->params($this->params()) ;
			}
		} else {
			$path = parent::path() ;

			// Object id transmited : we had it to the url.
			if (isset($this->_body['id'])) {
				$path->directory($this->_body['id']) ;
			}
		}

		return $path ;
	}

	/**
	 * Specific response object.
	 *
	 * @param array		$data		Get request results.
	 * @return \\Esprit\Response_Get
	 */
	protected function _response($data) {
		return new \Esprit\Response\Get($data, parent::options()) ;
	}
}
