<?php 

/**
* 
*/
class Generate
{
	function __construct()
	{
		# code...
	}

	function generateQuiz($type, $noQuestions, $noAnswers, $department, $courseCode) {
		$filePath = $_SERVER["DOCUMENT_ROOT"] .'/assets/template/Template-'. $type .'.docx';
		$templateProcessor = new \PhpOffice\PhpWord\Template($filePath);
		$templateProcessor->setValue('department', $department);
		
		$qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=234';
		$tmpfname = tempnam("/tmp", "UL_IMAGE");
		$img = file_get_contents($qrCode);
		file_put_contents($tmpfname, $img);
		$templateProcessor->setImageValueAlt('image1', $tmpfname);

		# Answer string buildup
		$answerBlocks = "";
		for ($i=0; $i <= $noAnswers; $i++) { 
			$answerBlocks.="□ ";
		}

		for ($i=0; $i <= 32; $i++) { 
			$field = "anserr" . $i . "c2";

			if ($i<=$noQuestions) {
				$templateProcessor->setValue($field, $answerBlocks);
			} else {
				$templateProcessor->setValue($field, "");
			}
		}
		// Saving the document as ODF file...
		$templateProcessor->saveAs('user-data/2.docx');
		return "Generated";
	}
}

?>