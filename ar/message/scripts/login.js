// Delete errors when user begins typing
document.forms[0].email.addEventListener("input", function () {
	document.getElementById("emailErr").innerHTML = "";
});
document.forms[0].password.addEventListener("input", function () {
	document.getElementById("passwordErr").innerHTML = "";
});
// toggle password visibility
document.getElementsByClassName("password-eye")[0].addEventListener("click", function () {
	document.forms[0].password.setAttribute("type", 
	document.forms[0].password.getAttribute("type") == "password" ? "text" : "password");
});
