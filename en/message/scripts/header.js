// Position "Hello user!" correctly
document.getElementsByClassName("hello")[0].style.left =
	(document.getElementsByClassName("menu")[0].getBoundingClientRect().left - 
	document.getElementsByTagName("h1")[0].getBoundingClientRect().right) / 2 - 
	document.getElementsByClassName("hello")[0].offsetWidth / 2 + 
	document.getElementsByTagName("h1")[0].getBoundingClientRect().right + "px";
// show dropdown on menu click
document.getElementsByClassName("menu")[0].addEventListener("click", function () {
	document.getElementsByClassName("dropdown")[0].classList.toggle("display-dropdown");
	document.getElementsByTagName("main")[0].addEventListener("click", function menuHide() {
		document.getElementsByClassName("dropdown")[0].classList.remove("display-dropdown");
		document.getElementsByTagName("main")[0].removeEventListener("click", menuHide);
	});
});
// position footer correctly
window.addEventListener("DOMContentLoaded", function() {
	document.getElementsByTagName("main")[0].style.minHeight =
		document.documentElement.clientHeight - 20 + "px";
});
