<?php
namespace Esprit\Request\Search\Criteria ;

/**
 * Generic class for all simple field/value criterias.
 */
abstract class FieldValue extends \Esprit\Request\Search\Criteria {

	/**
	 * Constructor : can directly take a field/value couple.
	 *
	 * @param mixed $in    In : field name or data array
	 * @param mixed $value Search value
	 */
	public function __construct($in = null, $value = null) {
		// Simpl instanciation
		if (isset($in)) {
			if (is_string($in)) {
				$this->data(['in' => $in, 'value' => $value]) ;
			} else {
				parent::__construct($in) ;
			}
		}
	}
}
