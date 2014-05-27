<?
namespace test;


error_reporting(E_ALL);


require_once __DIR__ . "/../__autoload.php";
require_once __DIR__ . "/../../php_inject/__autoload.php";


class MyController{
	private $db;


	function __construct(\pfc\SQL $database2){
		$this->db = $database2;
	}


	function home($error){
		?>
		<a href="/show">Show Data</a>

		<? if ($error) : ?>
		<hr />
		<p>Error: <?=$error ?>.</p>
		<? endif ?>

		<?
	}


	function error404(){
		return $this->home(404);
	}


	function show(){
		$rows = $this->db->query("select * from ppl", array() );
		?>
		<table border="1">
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Age</th>
				<th></th>
			</tr>
		<? foreach($rows as $row): ?>

			<tr>
				<td><?=$row["id"]	?></td>
				<td><?=$row["name"]	?></td>
				<td><?=$row["age"]	?></td>
				<td><a href="/show/<?=$row["id"]?>">show record</a></td>
			</tr>
		<? endforeach ?>

		</table>
		<?
	}


	function showDetails($id){
		$rows = $this->db->query("select * from ppl where id = %s", array($id) );
		$row = $rows->get();
		?>

		<? if ($row) : ?>
		<table border="1">
			<tr><td>ID:	</td><td><?=$row["id"]		?></td></tr>
			<tr><td>Name:	</td><td><?=$row["name"]	?></td></tr>
			<tr><td>Age:	</td><td><?=$row["age"]		?></td></tr>
		</table>
		<? else : ?>
		<p>No data found...</p>
		<? endif ?>

		<hr />

		<p><a href="/show">go back</a></p>
		<?
	}
}


class MyApplication extends \pfc\Framework\Application{
	private $database;
	private $database2;
	private $logger;


	function __construct(){
		// make configuration
		$this->conf = $this->getConfiguration();

		// make Logger
		$this->logger = $this->wireLogger();

		// make SQL
		$this->database = $this->wireSQL();

		// make cached SQL
		$this->database2 = $this->wireSQL2($this->database, $this->logger);
	}


	protected function getConfiguration(){
		 return array(
			"APP_PREFIX"		=> "demo_app_",

			"SQL_CACHE_PREFIX"	=> "sql_cache_",
			"SQL_CACHE_TTL"		=> 10,

			"DB_CONNECTION"		=> array(
							"connection_string" => "sqlite:/dev/shm/test.database.sqlite3"
						)
		);
	}


	protected function getInjectorConfiguration(){
		$conf = new \injector\Configuration();

		$conf->bind("database",		new \injector\BindValue($this->database));
		$conf->bind("database2",	new \injector\BindValue($this->database2));

		return array($conf);
	}


	protected function getRouter(\injector\Injector $injector){
		$ns  = __NAMESPACE__ . "\\";
		$inj = $injector;

		$r = new \pfc\Framework\Router();

		$r->map("/",		new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/"),		$inj,	$ns . "MyController::home"		));
		$r->map("/show",	new \pfc\Framework\Route(new \pfc\Framework\Path\Exact("/show"),	$inj,	$ns . "MyController::show"		));
		$r->map("/show/1",	new \pfc\Framework\Route(new \pfc\Framework\Path\Mask("/show/{id}"),	$inj,	$ns . "MyController::showDetails"	));
		$r->map("/error404",	new \pfc\Framework\Route(new \pfc\Framework\Path\CatchAll("/"),		$inj,	$ns . "MyController::error404"		));

		return $r;
	}


	function exact($_path){
		return "[$_path] exact";
	}


	// ===============================================


	private function wireLogger(){
		$logger = new \pfc\Logger();
		$logger->addOutput(new \pfc\OutputAdapter\Console());
		$logger->addFormat(new \pfc\LoggerFormat\Date() );
		$logger->addFormat(new \pfc\LoggerFormat\Profiler( new \pfc\Profiler() ) );

		return $logger;
	}


	private function wireSQL(){
		$db = new \pfc\SQL\PDO($this->conf["DB_CONNECTION"]);

		// make SQL to throw exceptions
		$db_exc = new \pfc\SQL\ExceptionDecorator($db);

		return $db_exc;
	}


	private function wireSQL2(\pfc\SQL $db, \pfc\Logger $logger){
		// prepare Cache in /dev/shm + Gzip
		$cacheAdapterFile = new \pfc\CacheAdapter\Shm($this->conf["APP_PREFIX"] . $this->conf["SQL_CACHE_PREFIX"]);
		$cacheAdapterFile->setTTL($this->conf["SQL_CACHE_TTL"]);

		$cacheAdapter     = new \pfc\CacheAdapter\CompressorDecorator($cacheAdapterFile, new \pfc\Compressor\GZip());

		// set Serializer to JSON
		$serializer   = new \pfc\Serializer\JSON();

		// make SQL to be cached
		$db2 = new \pfc\SQL\CacheDecorator($db, $cacheAdapter, $serializer, $logger);

		return $db2;
	}
}


MyApplication::start();

