<?php
namespace Esprit\Request ;

/**
 * Delete an index.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request
 */
class DeleteIndex extends CreateIndex {

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::DELETE,
		'magic' => 'index',
		'inject' => array(
			'params' => array('refresh')
		)
	) ;
}
