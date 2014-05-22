<?
namespace pfc;

/**
 * Tools for SQL adapter
 *
 */
class SQLTools{
	const DSNDELIMITER = "@@@";


	private function __construct(){
	}


	static function escapeQuery(SQL $adapter, $sql, array $params){
		$paramsEscaped = array();
		foreach($params as $p)
			$paramsEscaped[] = $adapter->escape($p);

		$escapedSQL = vsprintf($sql, $paramsEscaped);

		//echo $escapedSQL . "\n";

		return $escapedSQL;
	}
}

