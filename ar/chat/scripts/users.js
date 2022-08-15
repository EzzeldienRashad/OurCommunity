//add effects to user cards
for (let i = 0; i < document.getElementsByClassName("user").length; i++) {
    setTimeout(function() {
        document.getElementsByClassName("user")[i].style.transform = "rotateX(0deg)";
    }, i * 200)
}