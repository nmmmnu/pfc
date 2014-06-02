<?
namespace pfc;

/**
 * class with Version constants
 *
 */
class Info{
	const PRODUCT			= "PFC";

	const VERSION_MAJOR		= 0;
	const VERSION_MINOR		= 4;
	const VERSION_REVISION		= 0;

	const DATE			= "2014-05-09";
	const AUTHOR			= "Nikolay Mihaylov";
	const LICENCE			= "GPL";

	const _BANNER			= "%s Version %s, Copyleft %s, %s";

	static function VERSION(){
		return sprintf("%d.%d.%d",
				self::VERSION_MAJOR,
				self::VERSION_MINOR,
				self::VERSION_REVISION);
	}

	static function VERSION_FLOAT(){
		return sprintf("%d.%d",
				self::VERSION_MAJOR,
				self::VERSION_MINOR);
	}

	static function COPYRIGHT(){
		return sprintf(self::_BANNER,
				self::PRODUCT,
				self::VERSION(),
				self::DATE,
				self::AUTHOR);
	}

}

