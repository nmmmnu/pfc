<?
namespace pfc\Framework;

abstract class Application{
	private $_injector;
	private $_router;


	abstract protected function getInjectorConfiguration();
	abstract protected function getRouter(\injector\Injector $injector);


	function run(){
		$injectorConfiguration = $this->getInjectorConfiguration();

		$this->_injector = new \injector\Injector($injectorConfiguration);


		// ========================


		$this->_router = $this->getRouter( $this->_injector );


		// ========================

		if (isset($_SERVER["PATH_INFO"]))
			$path = $_SERVER["PATH_INFO"];
		else
			$path = "/";

		$this->_router->processRequest($path);
	}


	static function start(){
		// use late static binding to get the classname
		$classname = get_called_class();

		$app = new $classname;
		$app->run();
	}
}

