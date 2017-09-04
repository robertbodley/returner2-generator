<?php  

/**
* Main controller
*/

require $_SERVER["DOCUMENT_ROOT"] . "/src/View.php";
require $_SERVER["DOCUMENT_ROOT"] . "/src/Generate.php";


class Controller
{

	function indexLoad() {
		$view = new View();
		return $view->baseView("Generator", $view->indexView());
	}

	function generateLoad() {
		$Generator = new Generate();
		$Generator->generateQuiz("Quiz", 16, 4, "Computer Science2", "CSC3003S");

	}
}


?>
