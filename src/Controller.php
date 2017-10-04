<?php  

/**
* Main controller
*/

require $_SERVER["DOCUMENT_ROOT"] . "/src/View.php";
require $_SERVER["DOCUMENT_ROOT"] . "/src/Generate.php";
require $_SERVER["DOCUMENT_ROOT"] . "/src/QRCodeGenerator.php";


class Controller
{
	/**
	* indexLoad
	* Loads the index page. This consists of the form to generate the front cover.
	*/
	function indexLoad() {
		$view = new View();
		return $view->baseView("Generator", $view->indexView());
	}

	/**
	* generateLoad
	* Habndles teh calling of the generator class and returns the pdf file that has been generated.
	*/
	function generateLoad() {
		$Generator = new Generate();

		//creates array from all post variables
		$testQuestions=array();
		for ($i=1; $i <= $_GET['noq']; $i++) { 
			array_push($testQuestions, $_GET['q'.$i]);
		}

		//generates the main page pdf and qr code that is appended to qr code
		echo $Generator->generateMain($_GET['testType'], $_GET['noq'], $_GET['noapq'], $_GET['courseCode'], $testQuestions, $_GET['pagesPerTest'], $_GET['department']);
	}
}


?>
