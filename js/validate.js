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

	if(form.password.value == form.confirmPassword.value) {
		if(form.password.value == form.username.value) {
			alert("Error: Password must be different from Username!");
			form.password.focus();
			return false;
		}

		var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
		if(!re.test(form.password.value)) {
			alert("Error: Password must be at least 8 characters long and contain at least one number (0-9), one lowercase letter (a-z), and one uppercase letter (A-Z)!");
			form.password.focus();
			return false;
		}
	} else {
		alert("Error: Passwords must match!");
		form.password.focus();
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