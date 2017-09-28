<?php  

/**
* 
*/
class QRCodeGenerator
{	
	public $type;
	public $noQuestions;
	public $noAnswers;
	public $testDate;

	function generateQRCode($type, $noQuestions, $noAnswers, $courseCode) {
		$this->type = $type;
		$this->noQuestions = $noQuestions;
		$this->noAnswers = $noAnswers;
		$this->courseCode = $courseCode;

		$imgUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=".urlencode($this->generateQRData());

		return $imgUrl;
	}

	function generateQRData() {
		$json = $this->type . "---" . $this->noQuestions . "---" . $this->noAnswers . "---" . $this->courseCode;
		return $json;
	}
}

?>