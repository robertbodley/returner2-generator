<?php

/**
* Class: View
* Description: Returns the different HTML views for different url paths.
*/
class View
{
	
	/**
	* baseView
	* Returns the basic html view
	*/
	function baseView($title, $body) {
		$html = "
			<!DOCTYPE html>
			<html>
			<head>
				<title>{$title}</title>
				
				<link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='/assets/style.css'>
			</head>
			<body>
				{$body}
				<script src='https://code.jquery.com/jquery-3.2.1.min.js' integrity='sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=' crossorigin='anonymous'></script>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
				<script src='/assets/main.js'></script>
			</body>
			</html>
		";

		return $html;
	}
	/**
	* indexView
	* Generates the basic HTML used to display the input form to generate a pdf.
	*/
	function indexView() {
		$html = "
			<br>		
			<div class='container'>
				<div class='row justify-content-md-center'>
					<div class='col col-md-10 col-md-offset-1'>
						<div class='jumbotron'>
							<h1 class='display-3'>Front Page Generator</h1>
							<p class='lead'>Fill in the form below and click generate.</p>
						</div>

						<form action='/generate' method='GET' name='generateForm' id='generateForm'>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label>Type</label>
									<select name='testType' class='form-control' id='testType'>
										<option value='quiz'>Quiz</option>
										<option value='test'>Test</option>
									</select>
								</div>
								<div class='col-sm-6'>
									<label>Number of Questions</label>
									<input id='noq' name='noq' class='form-control' type='number' min='1' max='30' value='15'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label>Course Code</label>
									<input id='courseCode' name='courseCode' type='text' class='form-control' placeholder='CSC3003S'>
								</div>
								<div id='noapqBlock'  class='col-sm-6'>
									<label>Number of Pages Per Test(Including front cover)</label>
									<input id='pagesPerTest' name='pagesPerTest' class='form-control' type='number' min='1' value='5'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div id='noapqBlock'  class='col-sm-6'>
									<label>Number of Answers per Questions</label>
									<input id='noapq' name='noapq' class='form-control' type='number' min='1' max='10' value='5'>
								</div>
								<div id='departmentBlock'  class='col-sm-6'>
									<label>Department</label>
									<input id='department' name='department' class='form-control' placeholder='Computer Science'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom' id='questionTotals' style='display:none'>
								<div id='q1Block' class='col-sm-1'>
									<label>Q1 Total</label>
									<input id='q1' name='q1' type='text' class='form-control'>
								</div>
								<div  id='q2Block' class='col-sm-1'>
									<label>Q2 Total</label>
									<input id='q2' name='q2' type='text' class='form-control'>
								</div>
								<div  id='q3Block' class='col-sm-1'>
									<label>Q3 Total</label>
									<input id='q3' name='q3' type='text' class='form-control'>
								</div>
								<div  id='q4Block' class='col-sm-1'>
									<label>Q4 Total</label>
									<input id='q4' name='q4' type='text' class='form-control'>
								</div>
								<div  id='q5Block' class='col-sm-1'>
									<label>Q5 Total</label>
									<input id='q5' name='q5' type='text' class='form-control'>
								</div>
								<div  id='q6Block' class='col-sm-1'>
									<label>Q6 Total</label>
									<input id='q6' name='q6' type='text' class='form-control'>
								</div>
								<div  id='q7Block' class='col-sm-1'>
									<label>Q7 Total</label>
									<input id='q7' name='q7' type='text' class='form-control'>
								</div>
								<div  id='q8Block' class='col-sm-1'>
									<label>Q8 Total</label>
									<input id='q8' name='q8' type='text' class='form-control'>
								</div>
								<div  id='q9Block' class='col-sm-1'>
									<label>Q9 Total</label>
									<input id='q9' name='q9' type='text' class='form-control'>
								</div>
								<div  id='q10Block' class='col-sm-1'>
									<label>Q10 Total</label>
									<input id='q10' name='q10' type='text' class='form-control'>
								</div>
								<div class='clear'></div>
							</div>
							
							<div class='form-group'>
								<div class='col-sm-12'>
									<button type='submit' class='btn btn-primary'>Generate</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		";
		return $html;
	}
}


