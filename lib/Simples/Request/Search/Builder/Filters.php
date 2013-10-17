<?php
namespace Simples\Request\Search\Builder ;

/**
 * Search filter builder.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Request.Search
 */
class Filters extends Criteria {

	/**
	 * Returns a new Filter criteria.
	 *
	 * @param type $criteria		Criteria definition.
	 * @return \\Simples\Request_Search_Criteria_Filter
	 */
	protected function _criteria($criteria, array $options = array()) {
		return new \Simples\Request\Search\Criteria\Filter($criteria, $options) ;
	}
}
