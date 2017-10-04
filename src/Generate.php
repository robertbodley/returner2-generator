<?php 
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


/**
* Gernate
* Manages the generation of test and quizzes
*/
class Generate
{	
	/**
	* generateMain
	* The main handler function for generating tests and quizzes
	*
	* Parameters:
	* 	type - The type of paper that should be generated. 
	* 	noQuestions - number of questions in a test or quiz
	* 	noAnswers - number of answers per question in a test or quiz
	* 	courseCode - The course code that is embeded in a test or quiz
	* 	questionsOutOf - Used for the generation of test papers and displays on the test table to help marker
	* 	pagesPerTest - number of pages in a test (including the front page)
	* 	department - department that the test is for.
	*/
	function generateMain($type, $noQuestions, $noAnswers, $courseCode, $questionsOutOf, $pagesPerTest, $department) {

		// instantiate and use the dompdf class
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);

		$html = $this->templateGenerator($type, $noQuestions, $noAnswers, $courseCode, $questionsOutOf, $pagesPerTest, $department);

		// return $html;
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrate');
		$dompdf->render();
		return $dompdf->stream();
	}

	/**
	* templateGenerator
	* Builds up the basic test or quiz and calls other functions to finish the build up
	*
	* Parameters:
	* 	type - The type of paper that should be generated. 
	* 	noQuestions - number of questions in a test or quiz
	* 	noAnswers - number of answers per question in a test or quiz
	* 	courseCode - The course code that is embeded in a test or quiz
	* 	questionsOutOf - Used for the generation of test papers and displays on the test table to help marker
	* 	pagesPerTest - number of pages in a test (including the front page)
	* 	department - department that the test is for.
	*/
	function templateGenerator($type, $noQuestions, $noAnswers, $courseCode, $questionsOutOf, $pagesPerTest, $department) {

		$qr = new QRCodeGenerator();
		$imageSrc = $qr->generateQRCode($type, $noQuestions, $noAnswers, $courseCode, $pagesPerTest);

		//select test or quiz
		if ($type == "test") {
			$table = $this->createTestTable($questionsOutOf);

			$colSpan = 10;
			$colSpanTwo = 11;

		} else {
			$rows = $noQuestions;
			$cols = $noAnswers;
			$table = $this->createTable($rows, $cols);
			$colSpan = 10;
		}

		
		//styling for PDF
		$style = "
			table.main, .main th, .main td {
			    border: 4px solid black;
			    border-collapse: collapse;
			}

			.main th, .main td {
			    padding: 10px;
			    vertical-align:top;
			}

			table.inside {
				margin-top: 10px;
				padding: 10px;
			}

			table.inside, .inside th, .inside td {
			    border: 0px solid black;
			    border-collapse: collapse;
			    text-align:center;
			}

			.inside th, .inside td {
			    padding: 0px;
			    height: 20px;
			}

			.block {
				width: 27px;
				height: 15px;
				padding: 15px;
				margin: 15px;
			}

			.block div {
				height: 14px; 
				width: 14px; 
				border: 1px solid black;
				margin-left: 5px;
				margin-top: 2px;
			}

			.block div.hidden {
				border: 1px solid white;
			}

			h2 {
				padding: 0px;
				margin: 0px;
				margin-bottom: 18px;
				font-size: 12px;
			}

			.qrHolder {
				border-bottom: 4px solid black;
				margin-bottom: 5px;
			}

			.qrHolder img {
				width: 150px;
			}

			td.studentNumber {
				padding: 0px;
				margin: 0px;
			}

			.block div.hidden {
				border: 1px solid white;
			}

			td.answersTable {
				padding: 0px;
			}

			div.outOfBlock {
				border: 1px solid black;
				width: 50px;
				height: 15px;
				padding-right: 2px;
			}

			div.outOfBlock.noBorderTop {
				border-top: 0px;
				text-align: right;
				font-weight: bold;


			}
			div.outOfBlock.noBorderBottom {
				border-bottom: 0px;
				border-top: 0px;
			}

			.border {
				border: 1px solid black;
			}

		";


		//html body for pdf
		$body = "
			<table class='main' style='width:100%'>
			  <tr>
			    <th colspan='2' style='text-align: center; font-size: 24px'>
			    	University of Cape Town<br>
			    	Department of {$department}<br>
			    	" . ($type=='test' ? 'Test' : 'Quiz') . "
			    </th>
			  </tr>
			  <tr>
			    <td>
					<h2>Name</h2>
					<hr>
					<h2>Student Number</h2>
					<hr>
					<h2>Date</h2>
					<hr>
			    </td>
			    <td style='width: 55%'>
			    	<b>Instructions</b>
					<ul style='font-size: 12px;'>
						<li>
							Fill out the details above.
						</li>
						<li>
							Shade in your student number in the block to the left.
						</li>
						" . ($type=='test' ? '' : '<li>Shade your answers in the block below.</li>') . "
						<li>
							Use a dark pencil (so you can erase the mark if you make a mistake).
						</li>
					</ul>
			    </td> 
			  </tr>
			  <tr>
			    <td class='studentNumber'>
					<div class='qrHolder'>
						<div style='width: 50%; float: left;  font-size: 9px; line-height: 100px; padding-left: 10px; box-sizing: border-box;'>
							<b>Please do NOT write in this block</b>
						</div>
						<div style='width: 50%; height: 150px; float: right; margin-top: 5px; margin-bottom: 5px;'>
							<img src='{$imageSrc}'>
						</div>
						<div style='clear:both;'></div>
					</div>
					<b style='margin-left: 85px;'>Student Number</b>
					<table class='inside'>
						<tr>

							<td style='width: 25px;'>A</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>0</td>
						</tr>
						<tr>
							<td style='width: 25px;'>B</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>1</td>
						</tr>
						<tr>
							<td style='width: 25px;'>C</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>2</td>
						</tr>
						<tr>
							<td style='width: 25px;'>D</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>3</td>
						</tr>
						<tr>
							<td style='width: 25px;'>E</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>4</td>
						</tr>
						<tr>
							<td style='width: 25px;'>F</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>5</td>
						</tr>
						<tr>
							<td style='width: 25px;'>G</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>6</td>
						</tr>
						<tr>
							<td style='width: 25px;'>H</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>7</td>
						</tr>
						<tr>
							<td style='width: 25px;'>I</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>8</td>
						</tr>
						<tr>
							<td style='width: 25px;'>J</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td style='width: 25px;'>9</td>
						</tr>
						<tr>
							<td style='width: 25px;'>K</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>L</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>M</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>N</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>O</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>P</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>Q</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>R</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>S</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>T</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>U</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>V</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>W</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>X</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>Y</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
						<tr>
							<td style='width: 25px;'>Z</td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
							<td class='block'><div></div></td>
						</tr>
					</table>
			    </td>
			    <td class='answersTable' rowspan='1' style='" . ($type=='test' ? 'padding-left: 28px;' : 'padding-left: 24px;') . "'>
					<table class='inside'>
						". ($type=='test' ? '
						<tr  style="border: 1px solid black" >
							<td style="border: 1px solid black; background-color: rgb(200,200,200)"  colspan="'.$colSpanTwo.'"><b>Official Use Only!</b></td>
						</tr>' : '') ."
						<tr  style='border: 1px solid black' >
							<td style='border: 1px solid black' colspan='1'></td>
							<td style='border: 1px solid black; background-color: rgb(200,200,200)'  colspan='{$colSpan}'>" . ($type=='test' ? 'Questions' : 'Answers') . "</td>
						</tr>

						{$table}
						
					</table>
			    </td>
			  </tr>
			</table>
		";

		return $this->baseTemplate($style, $body);
	}

	/**
	* baseTemplate
	* Base html template
	*
	* Parameters:
	* 	style - css for the pdf
	* 	body - body of the html
	*/
	function baseTemplate($style, $body) {
		$html = "
			<!DOCTYPE html>
			<html>
			<head>
				<style>

					{$style}

				</style>
			</head>
			<body>
				{$body}
			</body>
			</html>
		";

		return $html;
	}

	/**
	* createTable
	* generates a quiz of rows rows and cols columns
	*
	* Parameters:
	* 	rows - number of rows in the quiz answer table
	* 	cols - number of columns in the quiz answer table
	*/
	function createTable($rows, $cols) {
		$table = "<tr><td style='width: 25px; border: 1px solid black'><b>Q</b></td>";

		//generate blocks for table
		for ($i=0; $i <= 9; $i++) { 
			$letter = chr(65+$i);
			if ($i<$rows) {
				//creates headings
				$table.="<td  style='border: 1px solid black' class='block'><b>{$letter}</b></td>";
			} else {
				//hide these blocks
				$table.="<td class='block'></td>";
			}
		} 

		$table.="</tr>";

		// Create table
		for ($i=1; $i <= 30; $i++) {			
			$table.= "<tr><td  style='border: 1px solid black'><b>{$i}</b></td>";

			//create answer blocks
			if ($i<=$rows) {
				for ($j=1; $j <= 10; $j++) { 
					if ($j<=$cols) {
						//show these blocks
						$table.="<td class='block'><div></div></td>";
					} else {
						//hide these blocks
						$table.="<td class='block'><div class='hidden'></div></td>";
					}
				}
			} else {
				for ($j=1; $j <= 10; $j++) { 
					$table.="<td class='block'><div class='hidden'></div></td>";
				}
			}
		}

		return $table;
	}


	/**
	* createTestTable
	* Used to generate the test table for a test
	*
	* Parameters:
	* 	outOf - array of what each question is out of
	*/
	function createTestTable($outOf) {
		$questions = sizeof($outOf);
		if ($questions<=5) {
			//generate first section if 5 or less blocks
			return $this->createTestTableSection($questions, 1, $outOf);
		} else {
			//generate both blocks if more than 5 questions
			return $this->createTestTableSection(5, 1, $outOf) . $this->createTestTableSection($questions-5, 6, $outOf);
		}
	}

	/**
	* createTestTableSection
	* Creates a single section in a test mark sheet
	*
	* Parameters:
	* 	questions - number of questions
	* 	starting - starting at question
	* 	outOf - array of what each question is out of
	*/
	function createTestTableSection($questions, $starting, $outOf) {
		$html = "<tr  style='border: 1px solid black'><td style='border: 1px solid black' colspan='1'></td>";
		$inputBoxOne = "<tr>
					<td colspan='1' class='block'></td>";
		$inputBoxTwo = "<tr>
					<td colspan='1' class='block'></td>";
		$seperationblock = "<tr>
					<td colspan='1' class='block'></td>";
		//add numbering
		for ($i=0; $i < 5; $i++) { 
			$qNumber = $starting+$i;
			$qOutOf = $outOf[$qNumber-1];
			$html.="<td style='border: 1px solid black; background-color: rgb(200,200,200)' colspan='2'><b>{$qNumber}</b></td>";
			$inputBoxOne.="<td colspan='2' style='border: 1px solid black; border-bottom: 1px solid white' class='block'></td>";
			$inputBoxTwo.="<td colspan='2' style='border: 1px solid black; border-bottom: 1px solid black; text-align: right; padding-right: 3px;' class='block'>/{$qOutOf}</td>";
			$seperationblock.="<td colspan='2' class='block'></td>";
		}

		$block = "";
		for ($i=0; $i < 10; $i++) { 
			if ($i < $questions*2) {
				$block.="<td class='block'><div></div></td>";
			} else {
				$block.="<td class='block'><div class='hidden'></div></td>";
			}
			
		}

		//create one row
		for ($i=0; $i < 10; $i++) { 
			$html.="<tr><td style='border: 1px solid black; background-color: rgb(200,200,200)' class='block'>{$i}</td>".$block."</tr>";
		}

		$html.=$inputBoxOne."</tr>".$inputBoxTwo."</tr>".$seperationblock."</tr></tr>";

		return $html;
	}

}






















?>