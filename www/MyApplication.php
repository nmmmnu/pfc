<?
namespace demo_app;


class MyApplication extends \pfc\Framework\Application{
	private $database;
	private $database2;
	private $logger;


	function __construct(){
		parent::__construct();

		// make Logger
		$this->logger = $this->wireLogger();

		// make SQL
		$this->database = $this->wireSQL();

		// make cached SQL
		$this->database2 = $this->wireSQL2($this->database, $this->logger);
	}


	protected function factoryConfiguration(){
		 return array(
			"app_prefix"		=> "demo_app_",

			"template_directory"	=> __DIR__ . "/../www/templates/",

			"sql_cache_prefix"	=> "sql_cache_",
			"sql_cache_ttl"		=> 10,

			"db_connection"		=> array(
							"connection_string" => "sqlite:/dev/shm/test.database.sqlite3"
						)
		);
	}


	protected function factoryVariables(){
		return array(
			"application_name"	=> "Demo Application",
			"application_copyright"	=> sprintf("&copy; %d, PFC", date("Y")) ,
			"page_name"		=> "Demo Application",
			"utf8_test"		=> "Здравейте, München, Français",
		);
	}


	protected function factoryInjectorConfiguration(){
		$injectorConf = new \injector\Configuration();

		$injectorConf->bind("database",		new \injector\BindValue($this->database));
		$injectorConf->bind("database2",	new \injector\BindValue($this->database2));

		return array($injectorConf);
	}


	protected function factoryTemplate(array $params){
		$template = new \pfc\Template\PHP($this->getConf("template_directory"));

		$template->bindParams($params);

		return $template;
	}


	protected function factoryRouter(\injector\Injector $injector){
		$ns  = __NAMESPACE__ . "\\" . "controllers" . "\\";
		$inj = $injector;

		$r = new \pfc\Framework\Router();

		$r->map("/",		new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/"),		new \pfc\Framework\TemplateController("home.html.php")	));
		$r->map("/error",	new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/error"),	new \pfc\Framework\TemplateController("error.html.php")	));

		$r->map("/complex",	new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/complex"),	new \pfc\Framework\Controller($inj,	$ns . "MyController::complex")		));
		$r->map("/json",	new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/json"),	new \pfc\Framework\Controller($inj,	$ns . "MyController::json")		));
		$r->map("/show",	new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/show"),	new \pfc\Framework\Controller($inj,	$ns . "MyController::show")		));
		$r->map("/show/1",	new \pfc\Framework\Route(new \pfc\Framework\Path\Mask("/show/{id}"),	new \pfc\Framework\Controller($inj,	$ns . "MyController::showDetails")	));

		$r->map("/error404",	new \pfc\Framework\Route(new \pfc\Framework\Path\CatchAll("/"),		new \pfc\Framework\Controller($inj,	$ns . "MyController::error404")		));

		return $r;
	}
	
	
	protected function factoryErrorPath(){
		return "/error";
	}


	// ===============================================


	private function wireLogger(){
		$logger = new \pfc\Logger();
		//$logger->addOutput(new \pfc\OutputAdapter\Console());
		$logger->addFormat(new \pfc\LoggerFormat\Date() );
		$logger->addFormat(new \pfc\LoggerFormat\Profiler( new \pfc\Profiler() ) );

		return $logger;
	}


	private function wireSQL(){
		$db = new \pfc\SQL\PDO($this->getConf("db_connection"));

		// make SQL to throw exceptions
		$db_exc = new \pfc\SQL\ExceptionDecorator($db);

		return $db_exc;
	}


	private function wireSQL2(\pfc\SQL $db, \pfc\Logger $logger){
		// prepare Cache in /dev/shm + Gzip
		$cacheAdapterFile = new \pfc\CacheAdapter\Shm($this->getConf("app_prefix") . $this->getConf("sql_cache_prefix"));
		$cacheAdapterFile->setTTL($this->getConf("sql_cache_ttl", 3600));

		$cacheAdapter     = new \pfc\CacheAdapter\CompressorDecorator($cacheAdapterFile, new \pfc\Compressor\GZip());

		// set Serializer to JSON
		$serializer   = new \pfc\Serializer\JSON();

		// make SQL to be cached
		$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, $logger);

		return $db2;
	}
}



