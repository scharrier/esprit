<?php
namespace Esprit\Request ;

/**
 * Delete a type.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request
 */
class DeleteType extends \Esprit\Request {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::DELETE,
		'required' => array(
			'options' => array('index')
		),
		'magic' => 'type'
	) ;

	/**
	 * Overrides constructor : gives the ability to pass the index name in the first param.
	 *
	 * @param array		$body				Request body.
	 * @param array		$options			Request options
	 * @param Esprit_Transport $transport	Transport client
	 */
	public function __construct($body = null, $options = null, \Esprit\Transport $transport = null) {
		if (isset($body['type'])) {
			$options['type'] = $body['type'] ;
			unset($body['type']) ;
		}
		parent::__construct($body, $options, $transport);
	}

	/**
	 * Check now if we have an index.
	 *
	 * @param mixed	 $body		Setter mode.
	 * @return array			Getter mode : the body.
	 * @throws \Esprit\Request_Exception
	 */
	public function body($body = null) {
		if (!isset($body) && !isset($this->_options['type'])) {
			throw new \Esprit\Request\Exception('Empty key "type" : you should specify the type name !') ;
		}
		return parent::body($body) ;
	}
}
