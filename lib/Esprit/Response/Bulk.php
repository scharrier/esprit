<?php
namespace Esprit\Response ;
/**
 * Bulk action response.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Response
 */
class Bulk extends \Esprit\Response {

	/**
	 * Set override : check each bulk item.
	 *
	 * @param array $data	Bulk data respose
	 * @return \\Esprit\Response_Bulk
	 * @todo	Generate an exception containing all the previous exceptions (actually, stop on the first)
	 */
	public function set($key = null, $data = null) {
		// Bulk response check
		if (isset($key['items'])) {
			foreach($key['items'] as $i => $action) {
				$response = $action[key($action)] ;
				$this->_check($response) ;
			}
		}
		$this->_data = $key ;
		return $this ;
	}
}
