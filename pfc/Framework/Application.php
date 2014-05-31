<?
namespace pfc\Framework;


use pfc\HTTPResponse;


/**
 * Framework Application
 *
 *
 */
abstract class Application{
	private $_injector;
	private $_router;
	private $_template;

	private $_conf;


	function __construct(){
		// make configuration
		$this->_conf = $this->factoryConfiguration();

		// make objects
		$this->buildObjects();

		// make injector
		$injectorConfiguration = $this->factoryInjectorConfiguration();

		$this->_injector = new \injector\Injector($injectorConfiguration);

		// make router
		$this->_router = $this->factoryRouter( $this->_injector );

		// make template
		$this->_template = $this->factoryTemplate();
	}


	/**
	 * Get configuration parameter
	 *
	 * @param string $name parameter name
	 * @param mixed $default default value
	 * @return mixed
	 */
	protected function getConf($name, $default = ""){
		if (isset($this->_conf[$name]))
			return $this->_conf[$name];

		return $default;
	}


	/**
	 * Get Link Router
	 *
	 * @return LinkRouter
	 */
	protected function getLinkRouter(){
		if ($this->_router)
			return $this->_router->getLinkRouter();

		return null;
	}


	abstract protected function buildObjects();

	abstract protected function factoryConfiguration();
	abstract protected function factoryInjectorConfiguration();
	abstract protected function factoryRouter(\injector\Injector $injector);
	abstract protected function factoryException(\Exception $e);
	abstract protected function factoryTemplate();


	protected function getRequestURI(){
		//if (isset($_SERVER["PATH_INFO"]))
		//	return $_SERVER["PATH_INFO"];

		if (isset($_SERVER["REQUEST_URI"]))
			return $_SERVER["REQUEST_URI"];

		return "/";
	}


	/**
	 * Run the application
	 */
	function run(){
		$path = $this->getRequestURI();


		try{
			$this->processRequest($path);
		}catch(\Exception $e){
			$controller = $this->factoryException($e);

			$this->processResult($controller);
		}
	}


	private function processRequest($path){
		// Get the controller
		$controller = $this->_router->processRequest($path);

		$this->processResult($controller);
	}


	private function processResult(AbstractController $controller){
		/*
		 * Result can be:
		 *  - string
		 *  - Response interface
		 *  - HTTPResponse class
		 */
		$result = $controller->process();


		// Test string
		if (is_string($result)){
			$result = new HTTPResponse($result);
			// result is HTTPResponse now.
		}


		// Test for Response
		if (is_object($result) && $result instanceof Response){
			if ($result instanceof Response\Template)
				$result->setTemplate($this->_template);

			$result	= $result->process();
			// result is HTTPResponse now.
		}


		// Test for HTTPResponse
		if (is_object($result) && $result instanceof HTTPResponse){
			$result->send();

			return;
		}


		throw new ControllerException("Controller result not seems to be correct type");
	}


	/**
	 * Create instance of the Application class and
	 * Run the application using run()
	 */
	static function start(){
		// use late static binding to get the classname
		$classname = get_called_class();

		$app = new $classname;
		$app->run();
	}
}

