<?
namespace pfc;

/**
 * StringBuilder / StringBuffer
 * 
 * Helps you avoid lame building like:
 * 
 * while(...){
 *    ...
 *    $s = $s . $x;
 * }
 *
 */
class StringBuilder implements Addable, UnitTest{
	private $_buffer;

	/**
	 * constructor
	 *
	 * @param string $s initial value
	 */
	function __construct($s = ""){
		$this->clear();

		$this->add($s);
	}


	function add($s){
		$s = (string) $s;
		
		if ($s != "")
			$this->_buffer[] = $s;
	}

	
	/**
	 * get buffer
	 *
	 * @param string $separator optional separator between the strings
	 * @return string buffer
	 */
	function get($separator = ""){
		return implode($separator, $this->_buffer);
	}


	function clear(){
		$this->_buffer = array();
	}


	static function test(){
		$s = "abc";

		$sb = new StringBuilder($s);


		for($i = 0; $i < 100; $i++){
			// make $s the lame way
			$s = $s . $i;
			
			// and add it to the Addable
			$sb->add($i);
		}

		assert($sb->get() == $s);
	}
}

