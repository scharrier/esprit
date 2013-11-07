<?php
namespace Esprit\Request ;

/**
 * Search. Oh yea, here it is.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 * @subpackage Request
 */
class Search extends \Esprit\Request {

	/**
	 * Do nothing with highlights
	 */
	const HIGHLIGHT_DO_NOTHING = false ;

	/**
	 * Replace highlighted values in the source
	 */
	const HIGHLIGHT_REPLACE = true ;

	/**
	 * Definition
	 *
	 * @var array
	 */
	protected $_definition = array(
		'method' => self::POST,
		'path' => '_search',
		'magic' => 'query',
	) ;


	/**
	 * Default body values.
	 *
	 * @var array
	 */
	protected $_body = array(
		'index' => null,
		'type' => null,
		'query' => null,
		'filter' => null,
		'facets' => null,
		'from' => null,
		'size' => null,
		'sort' => null,
		'highlight' => null,
		'fields' => null,
		'script_fields' => null,
		'explain' => null,
		'version' => null,
		'min_score' => null
	);

	/**
	 * Query builder.
	 *
	 * @var \Esprit\Request\Search\Builder\Query
	 */
	protected $_query ;

	/**
	 * Filter builder.
	 *
	 * @var \Esprit\Request_Search_Builder_Filter
	 */
	protected $_filters ;

	/**
	 * Request options.
	 *
	 * @var array
	 */
	protected $_options = array(
		'index' => null,
		'type' => null,
		'highlight' => \Esprit\Request\Search::HIGHLIGHT_DO_NOTHING,
		'fluid' => true
	);


	/**
	 * Constructor.
	 *
	 * @param mixed		$body				Request body
	 * @param array		$options			Array of options
	 * @param Esprit_Transport $transport	ES client instance
	 */
	public function __construct($body = null, $options = null, \Esprit\Transport $transport = null) {
		// Builders
		$this->_query = new \Esprit\Request\Search\Builder\Query() ;
		$this->_filters = new \Esprit\Request\Search\Builder\Filters() ;

		parent::__construct($body, $options, $transport);
	}

	/**
	 * Body without null values.
	 *
	 * @param array $body
	 * @return type
	 */
	public function body($body = null) {
		if (isset($body)) {
			return parent::body($body) ;
		}

		$body = parent::body() ;

		$body = [
			'query' => $this->_query->data(),
			'filters' => $this->_filters->data()
		] + $body ;

		// Sort format
		if (!empty($body['sort'])) {
			$body['sort'] = $this->_prepareSort($body['sort']) ;
		}

		// Highlights format
		if (!empty($body['highlight']['fields'])) {
			$highlight = array() ;
			foreach($body['highlight']['fields'] as $key => $value) {
				if (is_numeric($key)) {
					$highlight[$value] = new \stdClass() ;
				} else {
					$highlight[$key] = $value ;
				}
			}
			$body['highlight']['fields'] = $highlight ;
		}

		foreach($body as $key => $value) {
			if (!isset($value)) {
				unset($body[$key]) ;
			}
		}

		return $body ;
	}

	/**
	 * Prepare the sort clause : string, array, mixed.
	 *
	 * @param  mixed $sort String or array describing the sort clause
	 * @return array       Normalized array
	 */
	protected function _prepareSort($sort) {
		if (is_array($sort)) {
			$_sort = array() ;
			foreach($sort as $key => $value) {
				if (is_numeric($key)) {
					$_sub = $this->_prepareSort($value) ;
					if (is_array($_sub)) {
						$_sort = array_merge($_sort, $_sub) ;
					} else {
						$_sort[] = $_sub ;
					}
				} else {
					$_sort[$key] = $value ;
				}
			}
			$sort = $_sort ;
		} elseif (preg_match('/^(.*) +(.*)$/', $sort, $matches)) {
			$sort = array($matches[1] => $matches[2]) ;
		}

		return $sort ;
	}

	/**
	 * Query mode switcher.
	 *
	 * @param mixed		$query			Setter : Query definition.
	 * @return \\Esprit\Request_Search	This instance
	 */
	public function query() {
		$args = func_get_args() ;

		if (!$args) {
			return $this->_query ;
		} else {
			foreach($args as $criteria) {
				$this->_query->add($criteria) ;
			}
		}

		return $this ;
	}

	/**
	 * Filter mode switcher.
	 *
	 * @param mixed		$filter			Setter : Query definition.
	 * @return \\Esprit\Request_Search	This instance
	 */
	public function filter() {
		$args = func_get_args() ;

		if (!$args) {
			return $this->_filters ;
		} else {
			foreach($args as $criteria) {
				$this->_filters->add($criteria) ;
			}
		}

		return $this ;
	}

	/**
	 * Set the from param.
	 *
	 * @param int	$from		From value
	 * @return \\Esprit\Request_Search
	 */
	public function from($from) {
		$this->_body['from'] = $from ;
		return $this ;
	}

	/**
	 * Set the size.
	 *
	 * @param int	$size		Size value
	 * @return \\Esprit\Request_Search
	 */
	public function size($size) {
		$this->_body['size'] = $size;
		return $this ;
	}

	/**
	 * Set the sort param.
	 *
	 * @param string	$sort	Sort value
	 * @return \\Esprit\Request_Search
	 */
	public function sort($sort) {
		$this->_body['sort'] = $sort;
		return $this ;
	}

	/**
	 * Set the highlight param.
	 *
	 * @param string	$sort	Sort value
	 * @return \\Esprit\Request_Search
	 */
	public function highlight($highlight) {
		$this->_body['highlight'] = $highlight;
		return $this ;
	}

	/**
	 * Set the script_fields param.
	 *
	 * @param string	$fields	script_fields value
	 * @return \\Esprit\Request_Search
	 */
	public function scriptFields($fields) {
		$this->_body['script_fields'] = $fields;
		return $this ;
	}

	/**
	 * Set the explain param.
	 *
	 * @param bool	$explain	Explain value
	 * @return \\Esprit\Request_Search
	 */
	public function explain($explain) {
		$this->_body['explain'] = $explain;
		return $this ;
	}

	/**
	 * Set the min_score param.
	 *
	 * @param string	$sort	Sort value
	 * @return \\Esprit\Request_Search
	 */
	public function minScore($min_score) {
		$this->_body['min_score'] = $min_score;
		return $this ;
	}

	/**
	 * Set the fields param.
	 *
	 * @param string	$sort	Sort value
	 * @return \\Esprit\Request_Search
	 */
	public function fields($fields) {
		$this->_body['fields'] = $fields;
		return $this ;
	}

	/**
	 * Get a fluid called instance.
	 *
	 * @return Esprit_Base Some of the Search object part.
	 */
	public function instance() {
		if (!$this->_fluid || !$this->_current) {
			return $this ;
		}

		// We have used the fluid interface
		$object = '_' . $this->_current ;
		return $this->{$object}->instance() ;
	}

	/**
	 * Fluid options handling.
	 *
	 * @param  array $options Setter mode : options to set
	 * @return array          Getter mode : options of the current object or subobject instance
	 */
	public function options(array $options = null) {
		if ($this->_fluid) {
			if (isset($options)) {
				$this->{'_' . $this->_current}->options($options) ;
				return $this ;
			}
			return $this->{'_' . $this->_current}->options() ;
		}
		return parent::options($options) ;
	}

	/**
	 * Specific response object.
	 *
	 * @param array		$data		Search request results.
	 * @return \\Esprit\Response_Search
	 */
	protected function _response($data) {
		return new \Esprit\Response\Search($data, parent::options()) ;
	}
}
