Promise.all(Array.from(document.getElementsByClassName("images")[0].querySelectorAll("img")).filter(img => !img.complete).map(img => new Promise(resolve => { img.onload = img.onerror = resolve; }))).then(() => {
setTimeout(function() {
let imagesCounter = 1;
imgTransitionDuration = 500;
let slider = document.getElementsByClassName("images")[0];
let imagesNumber = slider.querySelectorAll("img").length - 2;
let imageWidth = slider.querySelector("img").offsetWidth;
let imageMargin = parseInt(getComputedStyle(slider.querySelector("img")).getPropertyValue("margin-left")) * 2;
let sliderTransform = (document.getElementsByTagName("main")[0].getBoundingClientRect().left + document.getElementsByTagName("main")[0].getBoundingClientRect().right) / 2
 - (slider.querySelectorAll("img")[1].getBoundingClientRect().left + slider.querySelectorAll("img")[1].getBoundingClientRect().right) / 2;
let initialSliderTransform = sliderTransform;
let finalSliderTransform = initialSliderTransform - (imagesNumber - 1) * (imageWidth + imageMargin);
let interval = setInterval(moveSlider, 1500);
slider.style.transform = "translateX(" + sliderTransform + "px)";
slider.style.transitionDuration = imgTransitionDuration / 1000 + "s";

function moveSlider() {
    if (imagesCounter >= imagesNumber ) {
        slider.style.transitionDuration = "";
        slider.style.transform = "translateX(" + initialSliderTransform + "px)";
        setTimeout(function() {
            sliderTransform = initialSliderTransform;
            slider.style.transitionDuration = imgTransitionDuration / 1000 + "s";
            imagesCounter = 2;
            slider.style.transform = "translateX(" + (sliderTransform - imageWidth - imageMargin) + "px)";
            sliderTransform -= imageWidth + imageMargin;
        }, 100);
    } else {
        imagesCounter++;
        slider.style.transform = "translateX(" + (sliderTransform - imageWidth - imageMargin) + "px)";
        sliderTransform -= imageWidth + imageMargin;
    }
}

function moveSliderReverse() {
    if (imagesCounter <= 1) {
        slider.style.transitionDuration = "";
        slider.style.transform = "translateX(" + finalSliderTransform + "px)";
        setTimeout(function() {
            sliderTransform = finalSliderTransform;
            slider.style.transitionDuration = imgTransitionDuration / 1000 + "s";
            imagesCounter = imagesNumber - 1;
            slider.style.transform = "translateX(" + (sliderTransform + imageWidth + imageMargin) + "px)";
            sliderTransform += imageWidth + imageMargin;
        }, 100);
    } else {
        imagesCounter--;
        slider.style.transform = "translateX(" + (sliderTransform + imageWidth + imageMargin) + "px)";
        sliderTransform += imageWidth + imageMargin;
    }
}
// slider manual move
let leftBtn = document.getElementsByClassName("arrow-left")[0];
let rightBtn = document.getElementsByClassName("arrow-right")[0];
leftBtn.addEventListener("click", function moveSliderLeft() {
    clearInterval(interval);
    leftBtn.removeEventListener("click", moveSliderLeft);
    moveSliderReverse();
    setTimeout(() => leftBtn.addEventListener("click", moveSliderLeft), imgTransitionDuration + 100);
    setTimeout(() => interval = setInterval(moveSlider, 1500), 500);
});
rightBtn.addEventListener("click", function moveSliderRight() {
    clearInterval(interval);
    rightBtn.removeEventListener("click", moveSliderRight);
    moveSlider();
    setTimeout(() => rightBtn.addEventListener("click", moveSliderRight), imgTransitionDuration + 100);
    setTimeout(() => interval = setInterval(moveSlider, 1500), 500);
});
}, 100);
});