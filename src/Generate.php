<?php 

/**
* 
*/
class Generate
{
	public $filename = '';

	function generateQuiz($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate) {
		$filePath = $_SERVER["DOCUMENT_ROOT"] .'/assets/template/Template-'. $type .'.docx';
		$templateProcessor = new \PhpOffice\PhpWord\Template($filePath);
		$templateProcessor->setValue('department', $department);
		
		# saves a generated qr code to a temp folder and the places it in the doc
		$qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=some_type_of_data';
		$tmpfname = tempnam("/tmp", "UL_IMAGE");
		$img = file_get_contents($qrCode);
		file_put_contents($tmpfname, $img);
		$templateProcessor->setImageValueAlt('image1', $tmpfname);

		# Answer string buildup
		$answerBlocks = "";
		for ($i=0; $i < $noAnswers; $i++) { 
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

		// Save document as docx
		$this->filename = $courseCode . '-' . $type . '-' . mt_rand(100,999);
		$templateProcessor->saveAs('user-data/'.$this->filename.'.docx');

		return "Generated";
	}
}

?>