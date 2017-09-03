<?php  

/**
* Main controller
*/

require "View.php";

class Controller
{

	function indexLoad() {
		$view = new View();
		return $view->baseView("Generator", $view->indexView());
	}
}


?>