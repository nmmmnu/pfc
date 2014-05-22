<?
namespace pfc\OutputAdapter;

use pfc\OutputAdapter;
use pfc\Addable as pfc_Addable;

/**
 * Addable OutputAdapter
 *
 * supports "writting" to Addable, for example StringBuilder
 *
 */
class Addable implements OutputAdapter{
	private $_addable;

	/**
	 * Constructor
	 * 
	 * @param pfc_Addable $addable pfc_Addable object
	 * 
	 */
	function __construct(pfc_Addable $addable){
		$this->_addable = $addable;
	}

	
	function write($line, $cr = true){
		if ($cr)
			$line = $line . "\n";

		$this->_addable->add($line);
	}


	static function test(){
		$sb = new \pfc\StringBuilder();
		$sa = new Addable($sb);

		$s = "";
		foreach(range(0,1000) as $x){
			$sa->write($x);
			$s = $s . $x . "\n";
		}

		assert($sb->get() == $s);
	}
}

