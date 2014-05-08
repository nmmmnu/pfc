<?
namespace pfc\Framework\Route;

use pfc\Framework\Route;


class Mask implements Route{
	private $_mask1;
	private $_mask2;
	private $_params;

	private $_controller;


	function __construct($mask, $controller){
		if (strlen($mask) == 0)
			$mask = self::HOMEPATH;

		list($this->_mask1, $this->_mask2, $this->_params) = self::parseMask($mask);

		if (count($this->_params) == 0)
			throw new RouteException("The mask needs to have at least one parameter");

		$this->_controller = $controller;
	}


	function link(array $params){
		$params2 = array();
		foreach($this->_params as $key)
			$params2[] = @$params[$key];

		return vsprintf($this->_mask2, $params2);
	}


	function match($path){
		$result = sscanf($path, $this->_mask1);

		if (!is_array($result))
			return false;

		$out = array();
		$i = 0;
		foreach($result as $r){
			if (!$r)
				return false;

			$key = @$this->_params[$i];

			if (!$key)
				return false;

			$out[$key] = $r;

			$i++;
		}

		return array($this->_controller, $out);
	}


	static private function parseMask($source){
		$mask1 = "";
		$mask2 = "";
		$params = array();

		$param = false;
		$sub = "";

		for ($i = 0; $i < strlen($source); $i++){
			$c = $source[$i];

			// open bracket
			if ($param == false && $c == "{"){
				$mask1 .= $sub;
				$mask2 .= $sub;

				$param = true;
				$sub = "";
				continue;
			}

			// close bracket
			if ($param == true  && $c == "}"){
				$next_c = @$source[$i + 1];

				$mask1 .= $next_c ? "%[^" . $next_c . "]" : "%s";
				$mask2 .= "%s";

				$params[] = $sub;

				$param = false;
				$sub = "";
				continue;
			}

			$sub .= $c;
		}

		if ($param == false){
			$mask1 .= $sub;
			$mask2 .= $sub;
		}

		return array($mask1, $mask2, $params);
	}


	static function test(){
		$r = new Mask("/{user}/{id}", "bla");

		assert( $r->match("/niki/23") != false );
		assert( $r->match("/niki") == false);
		assert( $r->match("/niki/") == false );

		assert($r->link(array(
			"id"	=> 102,
			"user"	=> "ivan",
		)) == "/ivan/102");
	}
}


