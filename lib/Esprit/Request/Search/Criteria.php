<?php
namespace Esprit\Request\Search ;

/**
 * Base criteria.
 */
abstract class Criteria {

	use \Esprit\Behavior\DataContainer ;

	/**
	 * Criteria data.
	 *
	 * @var array
	 */
	protected $_data = array() ;

	/**
	 * Constructor.
	 *
	 * @param mixed $data Criteria data or magic params.
	 */
	public function __construct($data = null) {
		if (isset($data) && is_array($data)) {
			$this->data($data) ;
		}
	}
}
