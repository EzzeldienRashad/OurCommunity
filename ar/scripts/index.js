addEventListener("load", function () {

//show links on menu click
let nav = document.getElementsByTagName("nav")[0];
document.getElementsByClassName("menu")[0].addEventListener("click", function () {
    nav.classList.toggle("nav-show");
    setTimeout(function () {
        if (nav.classList.contains("nav-show")) {
            document.addEventListener("click", function hideNav() {
                    nav.classList.remove("nav-show");
                    document.removeEventListener("click", hideNav);
            });
        }
    }, 0);
});
//resize header h1 and nav
if (document.getElementsByClassName("logo-header")[0]) {
    if (document.documentElement.offsetWidth > 420) {
        document.querySelector("header h1").style.width =
            document.getElementsByClassName("switch-lang")[0].getBoundingClientRect().left - 
            document.querySelector(".logo-header img").getBoundingClientRect().right - 40 + "px";
    } else {
        document.querySelector("header h1").style.width =
            document.getElementsByClassName("logo-header")[0].clientWidth - 
            (document.querySelector(".logo-header img").getBoundingClientRect().right + 10) + "px";
    }
}
if (document.querySelector("header nav")) {
    addEventListener("load", function () {
        if (document.documentElement.offsetWidth < 820) {
            document.querySelector("header nav").style.top = 
                document.getElementsByClassName("menu")[0].getBoundingClientRect().bottom + 5 + "px";
        }
    });
}
//slider
if (document.getElementById("slider")) {
    let descriptions = document.getElementsByClassName("description");
    let picsCont = document.getElementsByClassName("pics-cont")[0];
    let descHeight = Math.max(...Array.from(descriptions).map(e => e.scrollHeight));
    let sliderWidth = document.getElementsByClassName("moving-slider")[0].offsetWidth;
    let sliderTransform = 0;
    let descsCont = document.getElementsByClassName("descriptions")[0];
    for (desc of descriptions) {
        if (descHeight > desc.offsetHeight) {
            desc.style.height = descHeight + "px";
        }
    }
    for (let image of document.querySelectorAll(".moving-slider img")) {
        image.style.width = sliderWidth + "px";
        image.style.height = document.getElementsByClassName("slider-description")[0].offsetHeight + "px";
    }
    function moveSlider(progNum) {
        let progress = document.querySelectorAll(".progress-bar progress")[progNum];
        requestAnimationFrame(function incProgress() {
            progress.value = Number(progress.value) + 1;
            if (progress.value < 100) {
                setTimeout(() => requestAnimationFrame(incProgress), 20);
            } else {
                if (progNum >= document.querySelectorAll(".progress-bar progress").length - 1) {
                    for (let progress of document.querySelectorAll(".progress-bar progress")) {
                        setTimeout(() => progress.value = 0, 200);
                    }
                    setTimeout(function() {
                        moveSlider(0);
                        sliderTransform += sliderWidth;
                        picsCont.style.transform = "translateX(" + sliderTransform + "px)";
                        setTimeout(function() {
                            sliderTransform = 0;
                            picsCont.style.transitionDuration = "0s";
                            picsCont.style.transform = "translateX(0)";
                            setTimeout(() => picsCont.style.transitionDuration = "1s", 200);
                        }, 1000);
                        descsCont.querySelectorAll(".description")[0].style.zIndex = "0";
                        descsCont.querySelectorAll(".description")[descsCont.querySelectorAll(".description").length - 1].classList.remove("dec-opacity");
                        descsCont.querySelectorAll(".description")[descsCont.querySelectorAll(".description").length - 1].classList.add("inc-opacity");
                        setTimeout(function () {
                            for (let desc of descsCont.querySelectorAll(".description")) {
                                desc.style.zIndex = 1;
                                desc.classList.remove("dec-opacity");
                            }
                        }, 500);
                    }, 200);
                } else {
                    sliderTransform += sliderWidth;
                    setTimeout(function() {
                        moveSlider(progNum + 1);
                        picsCont.style.transform = "translateX(" + sliderTransform + "px)";
                        descsCont.querySelectorAll(".description")[descsCont.querySelectorAll(".description").length - 1 - progNum].classList.remove("inc-opacity");
                        descsCont.querySelectorAll(".description")[descsCont.querySelectorAll(".description").length - 1 - progNum].classList.add("dec-opacity");
                        setTimeout(() => descsCont.querySelectorAll(".description")[descsCont.querySelectorAll(".description").length - 1 - progNum].style.zIndex = "0", 500);
                    }, 200);
                }
            }
        });
    }
    moveSlider(0);
}
if (document.getElementById("services")) {
    addEventListener("scroll", function showServices() {
        if (window.pageYOffset + document.documentElement.clientHeight >= 
            document.documentElement.scrollTop + document.getElementById("services").getBoundingClientRect().top) {
                document.getElementById("services").style.transform = "translateX(0)";
                document.getElementById("services").style.opacity = "1";
                removeEventListener("scroll", showServices);
            }
    });
}
if (document.getElementById("offers")) {
    addEventListener("scroll", function showOffers() {
        if (window.pageYOffset + document.documentElement.clientHeight >= 
            document.documentElement.scrollTop + document.getElementById("offers").getBoundingClientRect().top) {
                document.getElementById("offers-title").style.transform = "translateY(0)";
                document.getElementById("offers-title").style.opacity = "1";
                document.getElementById("offers").style.transform = "translateY(0)";
                document.getElementById("offers").style.opacity = "1";
                removeEventListener("scroll", showOffers);
            }
    });
}
if (document.getElementById("faq")) {
    let accordions = document.getElementsByClassName("accordion");
    for (let i = 0; i < accordions.length; i++) {
        accordions[i].addEventListener("click", function() {
            this.classList.toggle("active");
            let answer = this.nextElementSibling;
            if (answer.style.maxHeight) {
                answer.style.maxHeight = "";
            } else {
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        })
    }
}

});