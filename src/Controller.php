<?php  

/**
* Main controller
*/

require $_SERVER["DOCUMENT_ROOT"] . "/src/View.php";
require $_SERVER["DOCUMENT_ROOT"] . "/src/Generate.php";
require $_SERVER["DOCUMENT_ROOT"] . "/src/QRCodeGenerator.php";


class Controller
{

	function indexLoad() {
		$view = new View();
		return $view->baseView("Generator", $view->indexView());
	}

	function generateLoad() {
		$Generator = new Generate();
		echo $Generator->generateMain('test', $_GET['noq'], $_GET['noapq'], $_GET['department'], $_GET['courseCode'], $_GET['testDate'], [6,4,2,6,6,34,87,23,12,7]);
	}
}


?>
