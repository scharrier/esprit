<?php
namespace Esprit ;

/**
 * Static calls. For simple usages of Esprit.
 *
 * This utility class can be used if you don't want to maintain your client
 * persistent. It gives you the ability to connect/disconnect/request your
 * ES server without any configuration / development.
 *
 * Example of usage :
 * Esprit::connect(array('host' => 'es.vtech.fr')) ;
 * echo Esprit::current()->search('charly')->limit(5)->total ;  // Where's charly ?
 * Esprit::disconnect() ;
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package	Esprit
 */
class Esprit {

	/**
	 * Factory.
	 *
	 * @var Esprit_Factory
	 */
	static protected $_factory ;

	/**
	 * Transport client.
	 *
	 * @var Esprit_Transport
	 */
	static protected $_client ;

	/**
	 * Connect your Esprit to your ES instance.
	 *
	 * @param array		$config		[optionnal] Configuration
	 * @return Simple_Transport		Connection client instance
	 */
	static public function connect(array $config = array()) {
		if (!self::connected()) {
			self::current($config)->connect() ;
		}

		return self::current($config) ;
	}

	/**
	 * Check if you're connected, now.
	 *
	 * @return bool
	 */
	static public function connected() {
		return isset(self::$_client) && self::$_client->connected() ;
	}

	/**
	 * Disconnect from the ES instance.
	 */
	static public function disconnect() {
		if (self::connected()) {
			self::current()->disconnect() ;
		}
	}

	/**
	 * Returns the current client.
	 *
	 * @return Simple_Transport
	 */
	static public function current(array $config = array()) {
		if (!isset(self::$_client)) {
			self::$_client = self::client($config) ;
		}
		if ($config) {
			return self::$_client->config($config) ;
		}
		return self::$_client ;
	}

	/**
	 * Returns a new client.
	 *
	 * @param array		$config		[optionnal] Client configuration
	 * @return Esprit_Client
	 */
	static public function client(array $config = array()) {
		$driver = 'http' ;
		if (isset($config['driver'])) {
			$driver = $config['driver'] ;
		}
		return self::_factory()->transport($driver, $config) ;
	}

	/**
	 * Gets the current factory (and generates it if necessary).
	 *
	 * @return Simple_Factory
	 */
	static protected function _factory() {
		if (!isset(self::$_factory)) {
			self::$_factory = new Factory() ;
		}
		return self::$_factory ;
	}
}
