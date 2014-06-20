$(document).ready( function() {
	var futureDate = new Date();
	futureDate.setDate(futureDate.getDate() + 30);
	$('#javascriptDisabled').hide();
	if (checkInput("date")) {
		$('#dateNotSupported').hide();
		$('#form1').show();
		$('#submitButton').removeAttr("disabled");
		document.getElementById('expiration').valueAsDate = futureDate;
	}
});

function validateForm(form) {
	
	var re = /^\w+$/;
	if(!re.test(form.username.value)) {
		alert("Error: Username must contain only letters, numbers and underscores!");
		form.username.focus();
		return false;
	}

	var enteredDate = new Date(form.expiration.value);
	var currentDate = new Date();
	var futureDate = new Date();
	futureDate.setDate(currentDate.getDate() + 91);

	if(enteredDate <= currentDate) {
		alert("Error: Date must be greater than today!");
		form.expiration.focus();
		return false;
	}

	if(enteredDate > futureDate) {
		alert("Error: Date must be less than 90 days from today!");
		form.expiration.focus();
		return false;
	}
}

function checkInput(type) {
	var input = document.createElement("input");
	input.setAttribute("type", type);
	return input.type == type;
}