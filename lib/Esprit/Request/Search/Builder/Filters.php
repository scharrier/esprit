<?php
namespace Esprit\Request\Search\Builder ;

/**
 * Search filter builder.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request.Search
 */
class Filters extends Criteria {

	/**
	 * Returns a new Filter criteria.
	 *
	 * @param type $criteria		Criteria definition.
	 * @return \\Esprit\Request_Search_Criteria_Filter
	 */
	protected function _criteria($criteria, array $options = array()) {
		return new \Esprit\Request\Search\Criteria\Filter($criteria, $options) ;
	}
}
