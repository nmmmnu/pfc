<?
namespace pfc\Framework;


use \pfc\Template;


class HelperController{
	function renderTemplate(Template $template, $filename){
		echo $template->render($filename);
	}
}

