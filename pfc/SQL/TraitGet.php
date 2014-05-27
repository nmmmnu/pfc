<?
namespace pfc\SQL;

trait TraitGet{
	function get($field = false){
		foreach($this as $result){
			if ($field)
				return $result[$field];

			return $result;
		}

		return false;
	}
}

