<?
namespace pfc;

/**
 * Tools for SQL adapter
 *
 */
class SQLTools{
	private function __construct(){
	}


	static function escapeQuery(SQL $adapter, $sql, array $params){
		$adapter->open();

		$paramsEscaped = array();
		foreach($params as $p)
			$paramsEscaped[] = $adapter->escape($p);

		$escapedSQL = vsprintf($sql, $paramsEscaped);

		//echo $escapedSQL . "\n";

		return $escapedSQL;
	}


	static function getResult(SQLResult $results, $field = false){
		foreach($results as $result){
			if ($field)
				return $result[$field];

			return $result;
		}

		return false;
	}
}

