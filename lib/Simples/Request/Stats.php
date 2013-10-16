<?php
namespace Simples\Request ;

/**
 * Stats (/_stats) request. Since ES 0.18.
 *
 * Returns some informations about the current cluster / or index.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 */
class Stats extends \Simples\Request {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::GET,
		'path' => '_stats'
	) ;

}
