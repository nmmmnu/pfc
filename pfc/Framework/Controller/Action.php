<?
namespace pfc\Framework\Controller;


/**
 * "Normal" controller.
 *
 * it uses class + method as callback
 *
 */
class Action implements Controller{
	const DELIMITER  = "::";
	const PARAM_PATH = "_path";
	const PARAM_CONF = "controller_configuration";


	private $_injector;
	private $_callback;
	private $_params;
	private $_params2;


	/**
	 * constructor
	 *
	 * @param \injector\AbstractInjector $injector injector to be used
	 * @param callable $callback
	 * @param array $params additional parameters for the injector
	 *
	 */
	function __construct(\injector\AbstractInjector $injector, $callback, array $params = array()){
		$this->_injector = $injector;
		$this->_callback = explode(self::DELIMITER, $callback);
		$this->_params   = $params;
	}


	function setRouting($path, array $args){
		$args[self::PARAM_PATH] = $path;

		$this->_params2  = $args;
	}


	function process(){
		$conf  = new \injector\Configuration();


		// Additional params first
		$this->bindParams($conf, $this->_params);

		// Routing params then
		$this->bindParams($conf, $this->_params2);


		$this->_injector->specifications()[self::PARAM_CONF] = $conf;

		$value = $this->_injector->callMethod($this->_callback[0], $this->_callback[1]);

		unset($this->_injector->specifications()[self::PARAM_CONF]);

		return $value;
	}


	private function bindParams(\injector\Configuration $conf, $array){
		if (is_array($array))
			foreach($array as $k => $v)
				$conf->bind($k, new \injector\BindValue($v));
	}
}

