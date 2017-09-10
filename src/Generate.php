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

	function generateQuiz($type, $noQuestions, $noAnswers, $department, $courseCode, $testDate) {


		// instantiate and use the dompdf class
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);
		$questionOutOf = [6, 7, 8, 91, 3, 5, 12, 7, 8, 91, 3, 5, 12, 7, 8];
		$html = $this->quizTemplate(30, 10, "numbers", $questionOutOf, "test");
		return $html;
		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrate');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		return $dompdf->stream();
	}

	function quizTemplate($rows, $cols, $headingType, $questionOutOf, $type) {
		$table = $this->createTable($rows, $cols, $headingType, $questionOutOf, $type);
		$colSpan = $cols+1;

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
			    height: 18px;
			}

			.block {
				width: 27px;
				height: 15px;
				padding: 15px;
				margin: 15px;
			}

			.block div {
				height: 10px; 
				width: 10px; 
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
				width: 100px;
			}

			td.studentNumber {
				padding: 0px;
				width: 35%;
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

		";

		$body = "
			<table class='main' style='width:100%'>
			  <tr>
			    <th colspan='2' style='text-align: center; font-size: 34px'>
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
			    <td>
			    	<b>Instructions</b>
					<ul style='font-size: 12px;'>
						<li>
							Fill out the details above.
						</li>
						<li>
							Shade in your student number in the block to the left.
						</li>
						<li>
							Shade your answers in the block below.
						</li>
						<li>
							Use a dark pencil (so you can erase the mark if you make a mistake).
						</li>
					</ul>
			    </td> 
			  </tr>
			  <tr>
			    <td class='studentNumber'>
					<div class='qrHolder'>
						<div style='width: 65%; float: left;  font-size: 12px; line-height: 70px; padding-left: 10px; box-sizing: border-box;'>
							<b>Please do not write in the block</b>
						</div>
						<div style='width: 35%; height: 100px; float: right; margin-top: 5px; margin-bottom: 5px;'>
							<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example'>
						</div>
						<div style='clear:both;'></div>
					</div>
					<b style='margin-left: 10px;'>Student Number</b>
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
						<tr>
							<td colspan='{$colSpan}'><b>" . ($type=='test' ? 'Marks' : 'Answers') . "</b></td>
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

	function createTable($rows, $cols, $headingType, $questionOutOf, $type) {
		$table = "<tr><td style='width: 25px;'><b>Q</b></td>";

		// Create heading
		if ($headingType=="numbers") {
			for ($i=0; $i < $cols; $i++) { 
				
				if ($i<=$rows) {
					$table.="<td class='block'><b>{$i}</b></td>";
				} else {
					$table.="<td class='block'></td>";
				}
			} 
		} else {
			for ($i=0; $i < $cols; $i++) { 
				$letter = chr(65+$i);
				if ($i<=$rows) {
					$table.="<td class='block'><b>{$letter}</b></td>";
				} else {
					$table.="<td class='block'></td>";
				}
			} 
		}

		//this sets the top border of outOfBlocks
		if ($type=="test") {
			$table.="<td style='width: 25px; border-bottom: 1px solid black;'></td></tr>";
		} else {
			$table.="<td style='width: 25px; border-bottom: 0px solid black;'></td></tr>";
		}

		// Create table
		for ($i=1; $i <= 30; $i++) {
			$question = round($i/2)-1; 
			$questionSection = (($i+1)%2);
			$amountOfAnswers = $questionOutOf[$question];
			

			if ($i<=$rows) {
				//set number format on side
				if ($type=="test") {
					$questionNumber = round($i/2);
					if ($i%2==1) {
						$table.= "<tr><td><b>{$questionNumber}</b></td>";
					} else {
						$table.= "<tr><td></td>";
					}
				} else {
					$table.= "<tr><td><b>{$i}</b></td>";
				}

				//create actual blocks
				if ($type == "test") {
					for ($j=1; $j <= 10; $j++) { 
						if ($j<=$cols && $amountOfAnswers>=$j-1 && $questionSection == 0) {
							$table.="<td class='block'><div></div></td>";
						} else if($j<=$cols && $amountOfAnswers>9 && $amountOfAnswers<20 && $j<=($amountOfAnswers%10) && $questionSection == 1) {
							$table.="<td class='block'><div></div></td>";
						} else if($j<=$cols && $amountOfAnswers>9 && $questionSection == 1 && $amountOfAnswers>20) {
							$table.="<td class='block'><div></div></td>";
						} else {
							$table.="<td class='block'><div class='hidden'></div></td>";
						}
					}
					if ($i%2==0) {
						$table.= "<td><div class='outOfBlock noBorderTop'>/{$questionOutOf[($i/2)-1]}</div></td></tr>";
					} else {
						$table.= "<td><div class='outOfBlock noBorderBottom'></div></td></tr>";
					}
				} else {
					for ($j=1; $j <= 10; $j++) { 
						if ($j<=$cols) {
							$table.="<td class='block'><div></div></td>";
						} else {
							$table.="<td class='block'><div class='hidden'></div></td>";
						}
					}
				}
				
			} else {
				$table.= "
					<tr>
						<td></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td class='block'><div class='hidden'></div></td>
						<td style='width: 25px;'></td>
					</tr>";
			}
		}

		return $table;
	}


}






















?>