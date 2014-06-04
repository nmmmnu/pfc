<?
namespace demo_app\controllers;


class MyController{
	private $db;

	private $ppl;


	function __construct(\pdb\SQL $database2){
		$this->ppl = new \demo_app\models\ppl($database2);
	}


	function show(){
		$rows = $this->ppl->getAll();

		return new \pfc\Framework\Response\Template("show.html.php", array(
			"page_name"	=> "Show all stuff",
			"rows"		=> $rows->fetchArray()
		));
	}


	function json(){
		$rows = $this->ppl->getAll();

		return new \pfc\Framework\Response\JSON( $rows->fetchArray() );
	}


	function complex(){
$html = <<<EOF
<h1>Bla</h1>
<hr />
<p><a href='/'>Go Back</a></p>
EOF;

		$http = new \pfc\HTTPResponse( $html );
		$http->setResponce(404);
		$http->setHeader("Bla", "Hello");

		return $http;
	}


	function showDetails($id){
		$rows = $this->ppl->get($id);
		$row = $rows->fetch();

		return new \pfc\Framework\Response\Template("showDetails.html.php", array(
			"page_name"	=> "Show detail information for " . $row["name"],
			"row"		=> $row
		));
	}
}
