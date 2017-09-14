<?php  

/**
* 
*/
class QRCodeGenerator
{	
	public $type;
	public $noQuestions;
	public $noAnswers;
	public $department;
	public $courseCode;
	public $testDate;

	function generateQRCode($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate) {
		$this->type = $type;
		$this->noQuestions = $noQuestions;
		$this->noAnswers = $noAnswers;
		$this->department = $department;
		$this->courseCode = $courseCode;
		$this->testDate = $testDate;

		$imgUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=".urlencode($this->generateJson());

		return $imgUrl;
	}

	function generateJson() {
		$json = $this->type . "---" . $this->noQuestions . "---" . $this->noAnswers . "---" . $this->department . "---" . $this->courseCode . "---" . $this->date;
		return $json;
	}
}

?>