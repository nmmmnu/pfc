<?
namespace pfc\UnitTests;

use pfc\Framework\Template\Template;

class TemplateTests{
	static function test(Template $template, $show = true){

		$params = array(
			"name"		=> "Niki\"",
			"city"		=> "Sofia"
		);

		$template->bindParams($params);

		$html = $template->render("page.html.php");

		if ($show){
		echo "You will see template HTML file here:\n";
		echo $html;
		echo "---end---\n\n";
		}
	}
}

