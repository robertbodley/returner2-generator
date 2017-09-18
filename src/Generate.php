<?php 
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


/**
* 
*/
class Generate
{
	public $filename = '';

	function generateMain($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate, $questionsOutOf) {

		// instantiate and use the dompdf class
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);

		$html = $this->templateGenerator($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate, $questionsOutOf);

		// return $html;
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrate');
		$dompdf->render();
		return $dompdf->stream();
	}

	function templateGenerator($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate, $questionsOutOf) {

		$qr = new QRCodeGenerator();
		$imageSrc = $qr->generateQRCode($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate);

		if ($type == "test") {
			$table = $this->createTestTable($questionsOutOf);

			if (sizeof($questionsOutOf)>5) {
				$colSpan = 10;
				$colSpanTwo = 11;
			} else {
				$colSpan = sizeof($questionsOutOf)*2;
				$colSpanTwo = sizeof($questionsOutOf)*2+1;
			}
		} else {
			$rows = $noQuestions;
			$cols = $noAnswers;
			$table = $this->createTable($rows, $cols);
			$colSpan = $cols;
		}

		

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

			h2 {
				padding: 0px;
				margin: 0px;
				margin-bottom: 25px;
				font-size: 15px;
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

		$body = "
			<table class='main' style='width:100%'>
			  <tr>
			    <th colspan='2' style='text-align: center; font-size: 24px'>
			    	University of Cape Town<br>
			    	Department of Computer Science<br>
			    	" . ($type=='test' ? 'Test' : 'Quiz') . "
			    </th>
			  </tr>
			  <tr>
			    <td>
					<h2>Name</h2>
					<hr>
					<h2>Student Number</h2>
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
							<b>Please do not write in the block</b>
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
							<td style='width: 25px;'>Z</td>
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
			    <td class='answersTable' rowspan='1'>
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

	function createTable($rows, $cols) {
		$table = "<tr><td style='width: 25px; border: 1px solid black'><b>Q</b></td>";

		for ($i=0; $i < $cols; $i++) { 
			$letter = chr(65+$i);
			if ($i<$rows) {
				$table.="<td  style='border: 1px solid black' class='block'><b>{$letter}</b></td>";
			} else {
				$table.="<td class='block'></td>";
			}
		} 

		$table.="</tr>";

		// Create table
		for ($i=1; $i <= 30; $i++) {			

			if ($i<=$rows) {

				$table.= "<tr><td  style='border: 1px solid black'><b>{$i}</b></td>";

				for ($j=1; $j <= 10; $j++) { 
					if ($j<=$cols) {
						$table.="<td class='block'><div></div></td>";
					} 
				}
			} 
		}

		return $table;
	}


	function createTestTable($outOf) {
		$questions = sizeof($outOf);
		if ($questions<=5) {
			return $this->createTestTableSection($questions, 1, $outOf);
		} else {
			return $this->createTestTableSection(5, 1, $outOf) . $this->createTestTableSection($questions-5, 6, $outOf);
		}
	}

	function createTestTableSection($questions, $starting, $outOf) {
		$html = "<tr  style='border: 1px solid black'><td style='border: 1px solid black' colspan='1'></td>";
		$inputBoxOne = "<tr>
					<td colspan='1' class='block'></td>";
		$inputBoxTwo = "<tr>
					<td colspan='1' class='block'></td>";
		$seperationblock = "<tr>
					<td colspan='1' class='block'></td>";
		//add numbering
		for ($i=0; $i < $questions; $i++) { 
			$qNumber = $starting+$i;
			$qOutOf = $outOf[$qNumber-1];
			$html.="<td style='border: 1px solid black; background-color: rgb(200,200,200)' colspan='2'><b>{$qNumber}</b></td>";
			$inputBoxOne.="<td colspan='2' style='border: 1px solid black; border-bottom: 1px solid white' class='block'></td>";
			$inputBoxTwo.="<td colspan='2' style='border: 1px solid black; border-bottom: 1px solid black; text-align: right; padding-right: 3px;' class='block'>/{$qOutOf}</td>";
			$seperationblock.="<td colspan='2' class='block'></td>";
		}

		$block = "";
		for ($i=0; $i < $questions*2; $i++) { 
			$block.="<td class='block'><div></div></td>";
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