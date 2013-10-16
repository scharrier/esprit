<?php
namespace Simples\Request\Search\Builder ;

/**
 * Search query builder.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Simples
 * @subpackage Request.Search
 */
class Query extends Criteria {

	/**
	 * Returns a new Query criteria.
	 *
	 * @param type $criteria		Criteria definition.
	 * @return \Simples_Request_Search_Criteria_Filter
	 */
	protected function _criteria($criteria, array $options = array()) {
		return new self($criteria, $options) ;
	}
}
