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