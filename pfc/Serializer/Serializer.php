<?
namespace pfc\Serializer;

/**
 * Adapter for serializing data
 *
 */
interface Serializer{
	/**
	 * serialize data
	 *
	 * @param mixed $data data to be serialized
	 * @return string
	 */
	function serialize($data);


	/**
	 * get iterator
	 *
	 * @param mixed $data data to be unserialized
	 * @return string
	 */
	function unserialize($data);


	/**
	 * get ContentType
	 *
	 * @return string
	 */
	function getContentType();
}

