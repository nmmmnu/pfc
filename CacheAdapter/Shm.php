<?
namespace pfc\CacheAdapter;

class Shm extends File{
	function __construct($file_prefix = "", $unlink_files = true){
		$dir = "/dev/shm";
		parent::__construct($dir, $file_prefix, $unlink_files);
	}
}



