<?php  

/**
* 
*/
class QRCodeGenerator
{	
	public $type;
	public $noQuestions;
	public $noAnswers;
	public $courseCode;
	public $pagesPerTest;

	function generateQRCode($type, $noQuestions, $noAnswers, $courseCode, $pagesPerTest) {
		$this->type = $type;
		$this->noQuestions = $noQuestions;
		$this->noAnswers = $noAnswers;
		$this->courseCode = $courseCode;
		$this->pagesPerTest = $pagesPerTest;

		$imgUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=".urlencode($this->generateQRData());

		return $imgUrl;
	}

	function generateQRData() {
		$data = $this->type . "---" . $this->noQuestions . "---" . $this->noAnswers . "---" . $this->courseCode . "---" . $this->pagesPerTest;
		return $data;
	}
}

?>