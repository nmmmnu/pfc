<?
namespace pfc;

/**
 * class with Version constants
 *
 */
class Info{
	const PRODUCT			= "PFC";

	const VERSION_MAJOR		= 0;
	const VERSION_MINOR		= 2;
	const VERSION_REVISION		= 0;

	const DATE			= "2014-04-29";
	const AUTHOR			= "Nikolay Mihaylov";
	const LICENCE			= "GPL";

	const BANNER			= "%s Version %s, Copyleft %s, %s";

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
		return sprintf(self::BANNER,
				self::PRODUCT,
				self::VERSION(),
				self::DATE,
				self::AUTHOR);
	}

}

