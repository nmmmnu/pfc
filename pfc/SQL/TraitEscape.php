<?
namespace pfc\SQL;

trait TraitEscape{
	protected function escapeQuery($sql, array $params){
		$this->open();

		$paramsEscaped = array();
		foreach($params as $p)
			$paramsEscaped[] = $this->escape($p);

		$escapedSQL = vsprintf($sql, $paramsEscaped);

		//echo $escapedSQL . "\n";

		return $escapedSQL;
	}


}

