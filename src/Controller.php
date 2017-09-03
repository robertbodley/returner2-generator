<?php  

/**
* Main controller
*/

require $_SERVER["DOCUMENT_ROOT"] . "/src/View.php";


class Controller
{

	function indexLoad() {
		$view = new View();
		return $view->baseView("Generator", $view->indexView());
	}

	function generateLoad() {
		$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($_SERVER["DOCUMENT_ROOT"] .'/assets/template/Template-Quiz.docx');
		$templateProcessor->setValue('department', 'Computer Science');
		$templateProcessor->setValue('testCol', '□ □ □ □ □ □ □ □ □');
		// Saving the document as ODF file...
		$templateProcessor->saveAs('test3.docx');

		return "Template-Quiz";
	}
}


?>
