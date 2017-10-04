<?php  

/**
* QRCodeGenerator
* Handles generation and storing of QR code information
*/
class QRCodeGenerator
{	
	public $type;
	public $noQuestions;
	public $noAnswers;
	public $courseCode;
	public $pagesPerTest;

	/**
	* generateQRCode
	* Hold the qr code object and returns an image
	*
	* Parameters:
	* 	type - The type of paper that should be generated. 
	* 	noQuestions - number of questions in a test or quiz
	* 	noAnswers - number of answers per question in a test or quiz
	* 	courseCode - The course code that is embeded in a test or quiz
	* 	pagesPerTest - number of pages in a test (including the front page)
	*/
	function generateQRCode($type, $noQuestions, $noAnswers, $courseCode, $pagesPerTest) {
		$this->type = $type;
		$this->noQuestions = $noQuestions;
		$this->noAnswers = $noAnswers;
		$this->courseCode = $courseCode;
		$this->pagesPerTest = $pagesPerTest;

		$imgUrl = "https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=".urlencode($this->generateQRData());

		return $imgUrl;
	}

	/*
	* generateQRData
	* Generates the string that is stored in the qr code
	*/
	function generateQRData() {
		$data = $this->type . "---" . $this->noQuestions . "---" . $this->noAnswers . "---" . $this->courseCode . "---" . $this->pagesPerTest;
		return $data;
	}
}

?>