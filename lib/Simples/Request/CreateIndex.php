<?php
namespace Simples\Request ;

/**
 * Creates an index.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Request
 */
class CreateIndex extends \Simples\Request {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::PUT,
		'magic' => 'index',
		'inject' => array(
			'params' => array('refresh')
		)
	) ;

	/**
	 * Request options.
	 *
	 * @var array
	 */
	protected $_options = array(
		'index' => null
	) ;

	/**
	 * Overrides constructor : gives the ability to pass the index name in the first param.
	 *
	 * @param array		$body				Request body.
	 * @param array		$options			Request options
	 * @param Simples_Transport $transport	Transport client
	 */
	public function __construct($body = null, $options = null, \Simples\Transport $transport = null) {
		if (isset($body['index'])) {
			$options['index'] = $body['index'] ;
			unset($body['index']) ;
		}
		if (isset($options['type'])) {
			unset($options['type']) ;
		}
		parent::__construct($body, $options, $transport);
	}

	/**
	 * Check now if we have an index.
	 *
	 * @param mixed	 $body		Setter mode.
	 * @return array			Getter mode : the body.
	 * @throws \Simples\Request_Exception
	 */
	public function body($body = null) {
		if (!isset($body) && !isset($this->_options['index'])) {
			throw new \Simples\Request\Exception('Empty key "index" : you should specify the index name !') ;
		}
		return parent::body($body) ;
	}
}
