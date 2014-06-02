<?
namespace pfc\Template;

use pfc\Loggable;

use pfc\CacheAdapter;
use pfc\Template;


/**
 * Cache template engine
 *
 */
class CacheDecorator implements Template{
	use Loggable;


	private $_template;
	private $_cacheAdapter;
	private $_ttl;


	/**
	 * constructor
	 *
	 * @param Template $template template engine
	 * @param CacheAdapter $cacheAdapter
	 * @param int ttl TTL
	 *
	 */
	function __construct(Template $template, CacheAdapter $cacheAdapter, $ttl, Logger $logger = null){
		$this->_template = $template;
		$this->_cacheAdapter = $cacheAdapter;
		$this->_ttl = $ttl;

		$this->setLogger($logger);
	}


	function bindParam($key, $value){
		$this->_template->bindParam($key, $value);
	}


	function bindParams(array $array){
		$this->_template->bindParams($array);
	}


	function escape($string){
		return $this->_template->escape($string);
	}


	function render($file, $content = ""){
		$key = $file;

		$content = $this->_cacheAdapter->load($key, $this->_ttl);

		if ($content !== false){
				$this->logDebug("Cache hit...");
				return $content;
		}

		$this->logDebug("Perform render()");

		$content = $this->_template->render($file, $content);

		$this->_cacheAdapter->store($key, $this->_ttl, $content);

		return $content;
	}


	static function test(){
		$cache = new \pfc\CacheAdapter\Shm("unit_tests_CacheDecorator_Template_");

		$logger = new \pfc\Logger();
		$logger->addOutput(new \pfc\OutputAdapter\Console());

		$phptemplate = new PHP(__DIR__ . "/../../data/templates/");

		$t = new CacheDecorator($phptemplate, $cache, 30);
		$t->setLogger($logger);

		\pfc\UnitTests\TemplateTests::test($t, false);
		\pfc\UnitTests\TemplateTests::test($t, false);
	}
}



