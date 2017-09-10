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
		echo $Generator->generateQuiz($_GET['testType'], $_GET['noq'], $_GET['noapq'], $_GET['department'], $_GET['courseCode'], $_GET['testDate']);
	}
}


?>
