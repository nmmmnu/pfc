<?
namespace pfc\UnitTests;

use pfc\Framework\Response;

class ResponseTests{
	static function test(Response $response){
		$data = $response->process();

		// Very naive test
		assert($data instanceof \pfc\HTTPResponse);
	}
}
