//Sets the ui for a test or quiz
$("#testType").change(function() {
	if ($("#testType").val() == 'test') {
		$('#noapqBlock').hide();
		$("#noq").attr({
	       	"max" : 10
	    });
	    $("#noq").val(10);
	    $("#noapq").val(10);

	    $('#questionTotals').show();

	    var count = $("#noq").val();
	   	for (var i = 1; i <= 10; i++) {
			if (i<=count) {
				$('#q'+i+'Block').show();
			} else {
				$('#q'+i+'Block').hide();
			}
		}
	} else {
		$('#noapqBlock').show();
		$("#noq").attr({
	       	"max" : 30
	    });
	     $('#questionTotals').hide();
	}
});

//changes the number of input blocks shown for a test when the noq is changed
$("#noq").change(function() {
	var count = $("#noq").val();

	for (var i = 1; i <= 10; i++) {
		if (i<=count) {
			$('#q'+i+'Block').show();
		} else {
			$('#q'+i+'Block').hide();
		}
	}
});

//validates the form before submission
$('form#generateForm').submit(function(e){
	return validate();
});

//validates the form
function validate() {
	var courseCode = $('#courseCode').val();
	var department = $('#department').val();

	//checks noq for the if quiz
	if (($("#noq").val() < 1 || $("#noq") > 30) && ("#testType").val() == 'quiz') {
		alert("Number of questions can only be between 1 & 30");
		return false;
	}

	//checks noq for the if test
	if (($("#noq").val() < 1 || $("#noq") > 10) && ("#testType").val() == 'test') {
		alert("Number of questions can only be between 1 & 10");
		return false;
	}

	if (($("#noapq").val() < 1 || $("#noapq") > 10) && ("#testType").val() == 'quiz') {
		alert("Number of answers per questions can only be between 1 & 10");
		return false;
	}

	if (courseCode == '') {
		alert("Course code is not complete");
		return false;
	}

	if (department == '') {
		alert("Department is not complete.");
		return false;
	}


	//validation for the test
	if ($("#testType").val() == 'test') {
		for (var i = 1; i <= $('#noq').val(); i++) {
			if ($('#q'+i).val() == '' || $('#q'+i+'Block').val() > 99) {
				alert('Question ' + i + ' has a problem with its total.');
				return false;
			}
		}
	}
	return true;
}