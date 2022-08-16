//show join/create group fields
let joinGroup = document.getElementsByClassName("join-group")[0], 
    createGroup = document.getElementsByClassName("create-group")[0], 
    enterForm = document.getElementsByClassName("enter-form")[0],
	showList = document.getElementsByClassName("show-list")[0], 
	joinGroupMethod = document.getElementsByClassName("join-group-method")[0],
	createGroupFields = document.getElementsByClassName("create-group-fields")[0],
	joinGroupFields = document.getElementsByClassName("join-group-fields")[0];
joinGroupFields.style.width = "0";
joinGroupMethod.style.height = "0";
createGroupFields.style.height = "0";
joinGroup.addEventListener("click", function () {
	joinGroupMethod.style.height = "";
    joinGroup.style.height = "0";
    createGroup.style.height = "0";
});
enterForm.addEventListener("click", function () {
    joinGroupFields.style.width = "";
    enterForm.style.width = "0";
    showList.style.width = "0";
});
createGroup.addEventListener("click", function () {
	createGroupFields.style.height = "";
    joinGroup.style.height = "0";
    createGroup.style.height = "0";
});
document.getElementsByClassName("fa-share")[0].addEventListener("click", function () {
    joinGroupMethod.style.height = "0";
    createGroupFields.style.height = "0";
    joinGroupFields.style.width = "0";
    joinGroup.style.height = "";
    createGroup.style.height = "";
	enterForm.style.width = "";
	showList.style.width = "";
});
if (document.getElementsByClassName("signupNameErr")[0]) {
	createGroup.style.transitionDuration = "0s";
	createGroup.style.height = "0";
	createGroup.style.transitionDuration = "";
	joinGroup.style.transitionDuration = "0s";
	joinGroup.style.height = "0";
	joinGroup.style.transitionDuration = "";
	createGroupFields.style.transitionDuration = "0s";
	createGroupFields.style.height = "";
	createGroupFields.style.transitionDuration = "";
}
if (document.getElementsByClassName("loginNamePasswordErr")[0]) {
	createGroup.style.transitionDuration = "0s";
	createGroup.style.height = "0";
	createGroup.style.transitionDuration = "";
	joinGroup.style.transitionDuration = "0s";
	joinGroup.style.height = "0";
	joinGroup.style.transitionDuration = "";
	joinGroupMethod.style.transitionDuration = "0s";
	joinGroupMethod.style.height = "";
	joinGroupMethod.style.transitionDuration = "";
	enterForm.style.transitionDuration = "0s";
	enterForm.style.width = "0";
	enterForm.style.transitionDuration = "";
	showList.style.transitionDuration = "0s";
	showList.style.width = "0";
	showList.style.transitionDuration = "";
	joinGroupFields.style.transitionDuration = "0s";
	joinGroupFields.style.width = "";
	joinGroupFields.style.transitionDuration = "";
}
// Check password strength
document.forms["createGroupFields"].signupGroupPassword.addEventListener("input", function () {
	let password = document.forms["createGroupFields"].signupGroupPassword.value;
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
document.forms["createGroupFields"].signupGroupName.addEventListener("input", function () {
	document.getElementById("signupNameErr").innerHTML = "";
});
document.forms["joinGroupFields"].loginGroupName.addEventListener("input", function () {
	document.getElementById("loginNameErr").innerHTML = "";
});
document.forms["joinGroupFields"].loginGroupPassword.addEventListener("input", function () {
	document.getElementById("loginPasswordErr").innerHTML = "";
});
// toggle password visibility
document.getElementsByClassName("signup-eye")[0].addEventListener("click", function () {
	document.forms["createGroupFields"].signupGroupPassword.setAttribute("type", 
	document.forms["createGroupFields"].signupGroupPassword.getAttribute("type") == "password" ? "text" : "password");
});
document.getElementsByClassName("login-eye")[0].addEventListener("click", function () {
	document.forms["joinGroupFields"].loginGroupPassword.setAttribute("type", 
	document.forms["joinGroupFields"].loginGroupPassword.getAttribute("type") == "password" ? "text" : "password");
});
