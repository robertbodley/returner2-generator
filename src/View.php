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
				<link rel='stylesheet' type='text/css' href='../assets/style.css'>
			</head>
			<body>
				{$body}
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
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

						<form>
							<div class='form-group'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Test Name</label>
									<input type='text' class='form-control' placeholder='Test 1'>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Test Date</label>
									<input type='text' class='form-control' placeholder='7 May 1996'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Course Code</label>
									<input type='text' class='form-control' placeholder='CSC3003S'>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Number of Questions</label>
									<input class='form-control' type='number' min='1' max='32' value='16'>
								</div>
								<div class='clear'></div>
							</div>

							<div class='form-group margin-bottom'>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Type</label>
									<select class='form-control'>
										<option value='0'>Test</option>
										<option value='1'>Quiz</option>
									</select>
								</div>
								<div class='col-sm-6'>
									<label for='exampleInputEmail1'>Number of Questions</label>
									<input class='form-control' type='number' min='1' max='32' value='16'>
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


