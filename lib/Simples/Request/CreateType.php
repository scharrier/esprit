<?php
namespace Simples\Request ;

/**
 * Creates a type. Simulate an API which doesn't exists in E.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Request
 */
class CreateType extends \Simples\Request\DeleteType {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::PUT,
		'path' => '_mapping',
		'required' => array(
			'options' => array('index')
		),
		'magic' => 'type'
	) ;

	/**
	 * Body : generates an empty mapping to create the type.
	 *
	 * @param mixed	 $body		Setter mode.
	 * @return array			Getter mode : the body.
	 * @throws \Simples\Request_Exception
	 */
	public function body($body = null) {
		if (!isset($body) && !isset($this->_options['type'])) {
			throw new Exception('Empty key "type" : you should specify the type name !') ;
		}
		if (!isset($body)) {
			return [$this->_options['type'] => new \stdClass()] ;
		}

		return parent::body($body) ;
	}

	/**
	 * Generates an exception if type already exists.
	 */
	public function execute() {
		// Check if type already exists : throw an exception
		$test = $this->_client->call($this->path(), 'GET') ;
		if (!empty($test[$this->_options['type']])) {
			throw new Exception('Type "' . $this->_options['type'] . '" already exists') ;
		}

		return parent::execute() ;
	}
}
