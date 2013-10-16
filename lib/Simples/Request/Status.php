<?php
namespace Simples\Request ;

/**
 * Status (/_status)
 *
 * Returns the cluster status.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 */
class Status extends \Simples\Request {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::GET,
		'path' => '_status'
	) ;
}
