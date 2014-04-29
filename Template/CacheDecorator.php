<?
namespace pfc\Template;

use pfc\CacheAdapter;
use pfc\Serializer;
use pfc\Template;
use pfc\UnitTest;


/**
 * Cache template engine
 *
 */
class CacheDecorator implements Template, UnitTest{
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
	function __construct(Template $template, CacheAdapter $cacheAdapter, $ttl){
		$this->_template = $template;
		$this->_cacheAdapter = $cacheAdapter;
		$this->_ttl = $ttl;
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
				$this->debug("Cache hit!\n");
				return $content;
		}

		$this->debug("Perform render()\n");

		$content = $this->_template->render($file, $content);

		$this->_cacheAdapter->store($key, $this->_ttl, $content);

		return $content;
	}


	private $_debug = false;
	function setDebug($debug){
		$this->_debug = $debug;
	}


	function debug($string){
		if ($this->_debug == false)
			return;

		echo $string;
	}


	static function test(){
		$cache = new \pfc\CacheAdapter\Shm("cached_template_");
		//$cache  = new \pfc\CacheAdapter\GZipDecorator($cache2);

		$phptemplate = new PHP("data/templates/");

		$t = new CacheDecorator($phptemplate, $cache, 10);
		$t->setDebug(true);

		//CacheDecorator

		$params = array(
			"name"		=> "Niki\"",
			"city"		=> "Sofia"
		);

		$t->bindParams($params);

		echo "You will see *cached* template HTML file here:\n";
		echo $t->render("page.html.php");
		echo "end\n";
	}
}



