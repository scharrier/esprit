<?php
namespace Esprit\Request\Search\Builder ;

/**
 * Search query builder.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request.Search
 */
class Query extends Criteria {

	/**
	 * Returns a new Query criteria.
	 *
	 * @param type $criteria		Criteria definition.
	 * @return \\Esprit\Request_Search_Criteria_Filter
	 */
	protected function _criteria($criteria, array $options = array()) {
		return new \Esprit\Request\Search\Criteria\Query($criteria, $options) ;
	}
}
