<?php

/**
* 
*/
class View
{
	
	function __construct()
	{
		# code...
	}

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
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
				<script src='/assets/main.js'></script>
			</body>
			</html>
		";

		return $html;
	}

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

						<form action='/generate' method='GET'>
							<div class='form-group'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Test Name</label>
									<input name='testName' type='text' class='form-control' placeholder='Test 1'>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Test Date</label>
									<input name='testDate' type='date' class='form-control' placeholder='07/05/1996'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Course Code</label>
									<input name='courseCode' type='text' class='form-control' placeholder='CSC3003S'>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Number of Questions</label>
									<input name='noq' class='form-control' type='number' min='1' max='30' value='15'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Type</label>
									<select name='testType' class='form-control'>
										<option value='Test'>Test</option>
										<option value='Quiz'>Quiz</option>
									</select>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Number of Answers per Questions</label>
									<input name='noapq' class='form-control' type='number' min='1' max='10' value='5'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Department</label>
									<input name='department' class='form-control' type='text' placeholder='Computer Science'>
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


