$("#testType").change(function() {
	if ($("#testType").val() == 'test') {
		$('#noapqBlock').hide();
		$("#noq").attr({
	       	"max" : 10
	    });
	    $("#noq").val(10);
	    $("#noapq").val(10);
	    $('#questionTotals').show();
	} else {
		$('#noapqBlock').show();
		$("#noq").attr({
	       	"max" : 30
	    });
	     $('#questionTotals').hide();
	}
});

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

$('form#generateForm').submit(function(e){
	return validate();
});

function validate() {
	var courseCode = $('#courseCode').val();
	if (courseCode == '') {
		alert("Course code is not complete");
		return false;
	}

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