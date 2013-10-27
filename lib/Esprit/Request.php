<?php
namespace Esprit ;

use \Esprit\Path ;
use \Esprit\Response ;

/**
 * ElasticSearch connection class : connect to a server, check its configuration, and exchange requests
 * and responses with this server.
 *
 * Actually only HTTP exchange are supported.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 */
abstract class Request {

	use \Esprit\Behavior\DataContainer ;

	/**
	 * Transport instance.
	 *
	 * @var EspritTransport
	 */
	protected $_client ;

	/**
	 * Request definition. Has to be defined in the request implementations.
	 *
	 * @var array|\Esprit\Request\Definition	During construction phase, array is replaced by a \Esprit\Request_Definition instance
	 */
	protected $_definition = array() ;

	/**
	 * Request body
	 */
	protected $_body = array() ;

	/**
	 * Request options.
	 *
	 * @var array
	 */
	protected $_options = array(
		'index' => null,
		'type' => null
	) ;

	/**
	 * Current response
	 *
	 * @var string
	 */
	protected $_response ;

	/**
	 * Method GET
	 */
	const GET = 'GET' ;

	/**
	 * Method POST
	 */
	const POST = 'POST' ;

	/**
	 * Method PUT
	 */
	const PUT = 'PUT' ;

	/**
	 * Method DELETE
	 */
	const DELETE = 'DELETE' ;

	/**
	 * Constructor.
	 *
	 * @param EspritTransport $transport		Connection to use.
	 */
	public function __construct($body = null, $options = null, \Esprit\Transport $transport = null) {
		$this->_definition = new \Esprit\Request\Definition($this->_definition) ;

		if (isset($body)) {
			$this->body($body) ;
		}

		if (isset($options)) {
			$this->options($options) ;
		}

		if (isset($transport)) {
			$this->_client = $transport ;
		}
	}

	/**
	 * Returns the current request definition.
	 *
	 * @return \Esprit\Request_Definition	The definition instance.
	 */
	public function definition() {
		return $this->_definition ;
	}

	/**
	 * Returns the base path for the current request.
	 *
	 * @return string
	 */
	public function path() {
		$path = new Path() ;

		$index = $this->index() ;

		if ($index) {
			$path->directory(trim($index,'/')) ;
			$type = $this->type() ;
			if ($type) {
				$path->directory(trim($type, '/')) ;
			}
		}

		if ($this->definition()->path()) {
			$path->directory(trim($this->definition()->path(), '/')) ;
		}

		if ($this->definition()->inject('params')) {
			$path->params($this->params()) ;

		}

		return $path ;
	}

	/**
	 * Returns the method for the current request.
	 *
	 * @return string
	 */
	public function method() {
		return $this->definition()->method() ;
	}

	/**
	 * Get the current index / indices
	 *
	 * @param type $index
	 * @return \\Esprit\Request
	 */
	public function index() {
		if (!isset($this->_options['index'])) {
			return '' ;
		}
		if (is_array($this->_options['index'])) {
			return implode(',', $this->_options['index']) ;
		}
		return $this->_options['index'] ;
	}

	/**
	 * Getter / setter : current type(s)
	 *
	 * @param mixed		$type		Type (string) or types (array)
	 * @return \\Esprit\Request
	 */
	public function type() {
		if (!isset($this->_options['type'])) {
			return '' ;
		}
		if (is_array($this->_options['type'])) {
			return implode(',', $this->_options['type']) ;
		}
		return $this->_options['type'] ;
	}

	/**
	 * Transport client setter/getter : if $client is given, sets $this->_client. Else,
	 * returns the current $this->_client.
	 *
	 * This permits chained calls :
	 * $request->client($client)->execute() ;
	 *
	 * @param Esprit_Transport $client		Setter mode : the client
	 * @return \\Esprit\Request				setter mode : current request. Getter mode : current client.
	 */
	public function client(\Esprit\Transport $client = null) {
		if (isset($client)) {
			$this->_client = $client ;
			return $this ;
		}

		return $this->_client ;
	}

	/**
	 * Executes the request and returns the response.
	 *
	 * @return null
	 */
	public function execute() {
		$response = array() ;

		if (isset($this->_client)) {
			$response = $this->_client->call($this->path(), $this->method(), $this->to('json')) ;
		}

		$this->_response = $this->_response($response) ;

		return $this->_response ;
	}

	/**
	 * Check if the request has been executed.
	 *
	 * @return bool
	 */
	public function executed() {
		return isset($this->_response) ;
	}

	/**
	 * Getter / setter : body of the request.
	 *
	 * @param array		$body		Setter : body
	 * @return \\Esprit\Request|array	Setter : $this . Getter : current body.
	 */
	public function body($body = null) {
		if (isset($body)) {
			$required = $this->definition()->required('body') ;
			foreach($required as $key) {
				if (!isset($body[$key])) {
					throw new \Esprit\Request\Exception('Required body key "' . $key . '" missing') ;
				}
			}
			$this->_body = array_merge($this->_body, $body) ;
			return $this ;
		}
		$delete = array_flip($this->definition()->inject('params')) ;
		$return = array_diff_key($this->_body, $delete) ;
		return $return ;
	}

	/**
	 * Getter / setter : options for the request.
	 *
	 * @param array		$options		Setter : options
	 * @return \\Esprit\Request|array	Setter : $this . Getter : current options.
	 */
	public function options(array $options = null) {
		if (isset($options)) {
			$required = $this->definition()->required('options') ;
			foreach($required as $key) {
				if (!isset($options[$key])) {
					throw new \Esprit\Request\Exception('Required option key "' . $key . '" missing') ;
				}
			}
			$this->_options = $options + $this->_options;
			return $this ;
		}
		$delete = array('index' => true, 'type' => true) + array_flip($this->definition()->inject('params')) ;
		return array_diff_key($this->_options, $delete) ;
	}

	/**
	 * Returns the path params.
	 *
	 * @return array
	 */
	public function params() {
		$params = $this->definition()->inject('params') ;
		if (!empty($params)) {
			$params = array_intersect_key(array_filter($this->_options), array_flip($params)) ;
		}
		return $params ;
	}

	/**
	 * Here the magic happens ! You can directly call a response value from the request. If
	 * the request hasn't been executed, execute it and then asks your value to the response
	 * object.
	 *
	 * Yea, you can call :
	 * $status->version->number
	 *
	 * @param string	$name		Var name
	 * @return mixed
	 */
	public function __get($name) {
		if (!$this->executed()) {
			$this->execute() ;
		}
		return $this->_response->get($name) ;
	}

	/**
	 * Exporter custom data.
	 *
	 * @return array
	 */
	protected function _data(array $options = array()) {
		return $this->body() ;
	}

	/**
	 * Generates a standard response. Overriden in specific requests.
	 *
	 * @param array		$response		Data.
	 * @return \\Esprit\Response		Structured response.
	 */
	protected function _response($response) {
		return new Response($response, $this->options()) ;
	}
}
