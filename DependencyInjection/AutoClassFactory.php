<?
namespace pfc\DependencyInjection;


class AutoClassFactory extends ClassFactory{
	const NAMESPACE_SEPARATOR = "\\";


	private $_namespace;


	function __construct($namespace = ""){
		$this->_namespace = self::checkNamespace($namespace);
	}


	protected function classLoader($classname){
		$classname_class = $this->_namespace . $classname;

		return new $classname_class;
	}


	private static function checkNamespace($namespace){
		if ($namespace == "")
			return self::NAMESPACE_SEPARATOR;

		if ($namespace[0] != self::NAMESPACE_SEPARATOR)
			$namespace = self::NAMESPACE_SEPARATOR . $namespace;

		if (substr($namespace, -1) != self::NAMESPACE_SEPARATOR)
			$namespace = $namespace . self::NAMESPACE_SEPARATOR;

		return $namespace;
	}
}
