<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Raw criteria : let you directly give the ES JSON request.
 */
class Raw extends \Esprit\Request\Search\Criteria {

	/**
	 * Constructor : only one parameter (no $in)
	 *
	 * @param mixed $field  Field name or data array
	 * @param array  $data  Optionnal data
	 */
	public function __construct(array $data = null) {
		if (isset($data)) {
			$this->data($data) ;
		}
	}

	/**
	 * Body data
	 *
	 * @return array Body
	 */
	protected function _data() {
		$data = $this->_data ;

		// Export objects inside the raw data
		array_walk_recursive($data, function(&$data) {
			if (is_object($data)) {
				$data = $data->to('array') ;
			}
		}) ;

		return $data ;
	}
}
