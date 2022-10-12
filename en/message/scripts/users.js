let search = document.getElementsByClassName("search-input")[0];
let users = document.getElementsByClassName("user");
//add effects to user cards
for (let i = 0; i < users.length; i++) {
    setTimeout(function() {
        users[i].style.transform = "rotateX(0deg)";
    }, i * 50)
}
//search users
search.addEventListener("input", function () {
    for (let user of users) {
        if (!user.innerHTML.toLowerCase().startsWith(search.value.toLowerCase())) {
            user.setAttribute("hidden", true);
        } else {
            user.removeAttribute("hidden");
        }
    }
});
document.addEventListener("click", function (event) {
    // Delete errors when user begins writing
    let div = event.target.closest("div.user");
    let form;
    let eye;
    if (div) {
        form = div.querySelector("form");
        eye = div.querySelector("span.password-eye");
    }
    if (form) {
        form.hidden = false;
        form.oninput = function () {
            document.getElementById("loginNameErr").innerHTML = "";
        }
        form.oninput = function () {
            document.getElementById("loginPasswordErr").innerHTML = "";
        }
        // toggle password visibility
        setTimeout(function () {
            eye.onclick = function () {
                form.loginGroupPassword.setAttribute("type", 
                form.loginGroupPassword.getAttribute("type") == "password" ? "text" : "password");
            };
        }, 0);
    }
});