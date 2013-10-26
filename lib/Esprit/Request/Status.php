<?php
namespace Esprit\Request ;

/**
 * Status (/_status)
 *
 * Returns the cluster status.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 */
class Status extends \Esprit\Request {

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
