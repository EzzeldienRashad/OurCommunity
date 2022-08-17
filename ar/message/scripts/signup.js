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
			passStrengthInfo.innerHTML = "<progress value='1' max='5' style='--progress-color: red;'></progress>*كلمة سر شديدة الضعف";
			passStrengthInfo.style.color = "red";
			break;
		case 2:
			passStrengthInfo.innerHTML = "<progress value='2' max='5' style='--progress-color: deeppink;'></progress>*كلمة سر ضعيفة";
			passStrengthInfo.style.color = "deeppink";
			break;
		case 3:
			passStrengthInfo.innerHTML = "<progress value='3' max='5' style='--progress-color: orange;'></progress>*كلمة سر لا بأس لها";
			passStrengthInfo.style.color = "orange";
			break;
		case 4:
			passStrengthInfo.innerHTML = "<progress value='4' max='5' style='--progress-color: lightgreen;'></progress>*كلمة سر جيدة";
			passStrengthInfo.style.color = "lightgreen";
			break;
		case 5:
			passStrengthInfo.innerHTML = "<progress value='5' max='5' style='--progress-color: green;'></progress>*كلمة سر ممتازة"
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
