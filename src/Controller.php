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
		print_r($_GET);
		$Generator = new Generate();
		$Generator->generateQuiz($_GET['testType'], $_GET['noq'], $_GET['noapq'], $_GET['department'], $_GET['courseCode'], $_GET['testDate']);

		$file_url = '/user-data/CSC3002S-Test-269.docx';
		$parts = pathinfo($file_url);
		$fsize = filesize($file_url);
 		header("Content-Length: ".$fsize);
		header('Content-type: application/vnd.openxmlformats- officedocument.wordprocessingml.document');
	    header('Content-Disposition: attachment; filename="'.$parts['basename'].'"');
	    ob_clean();
	    flush();
	    readfile($_SERVER["DOCUMENT_ROOT"] . '/user-data/' . $Generator->filename . '.docx');

	}
}


?>
