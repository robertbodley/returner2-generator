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

		$testQuestions=array();
		for ($i=1; $i <= $_GET['noq']; $i++) { 
			array_push($testQuestions, $_GET['q'.$i]);
		}

		echo $Generator->generateMain($_GET['testType'], $_GET['noq'], $_GET['noapq'], $_GET['courseCode'], $testQuestions, $_GET['pagesPerTest']);
	}
}


?>
