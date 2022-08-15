// Check password strength
document.forms[0].password.addEventListener("input", function () {
	let password = document.forms[0].password.value;
	let passStrengthInfo = document.getElementById("passStrengthInfo");
	let strength = /[a-z]/.test(password) + /[A-Z]/.test(password) +
		/\d/.test(password) + (password.length >= 8) +
		/[-!@#$%^&*\(\)_=+`~.>,<\/?'";:\\|]/.test(password)
	switch (strength) {
		case 0:
			passStrengthInfo.innerHTML = "";
			passStrengthInfo.style.color = "";
			break;
			case 1:
			passStrengthInfo.innerHTML = "*very weak password &nbsp;&nbsp;<progress value='1' max='5' style='--progress-color: red;'></progress>";
			passStrengthInfo.style.color = "red";
			break;
		case 2:
			passStrengthInfo.innerHTML = "*weak password &nbsp;&nbsp;<progress value='2' max='5' style='--progress-color: deeppink;'></progress>";
			passStrengthInfo.style.color = "deeppink";
			break;
		case 3:
			passStrengthInfo.innerHTML = "*good password &nbsp;&nbsp;<progress value='3' max='5' style='--progress-color: orange;'></progress>";
			passStrengthInfo.style.color = "orange";
			break;
		case 4:
			passStrengthInfo.innerHTML = "*very good password &nbsp;&nbsp;<progress value='4' max='5' style='--progress-color: lightgreen;'></progress>";
			passStrengthInfo.style.color = "lightgreen";
			break;
		case 5:
			passStrengthInfo.innerHTML = "*excellent password &nbsp;&nbsp;<progress value='5' max='5' style='--progress-color: green;'></progress>"
			passStrengthInfo.style.color = "green";
			break;
	}
})

// Delete errors when user begins writing
document.forms[0].email.addEventListener("input", function () {
	document.getElementById("emailErr").innerHTML = "";
});

document.forms[0].name.addEventListener("input", function () {
	document.getElementById("nameErr").innerHTML = "";
});
// toggle password visibility
document.getElementsByClassName("password-eye")[0].addEventListener("click", function () {
	document.forms[0].password.setAttribute("type", 
	document.forms[0].password.getAttribute("type") == "password" ? "text" : "password");
});
