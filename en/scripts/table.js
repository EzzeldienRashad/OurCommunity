//show images correctly on small screens
let main = document.getElementsByTagName("main")[0];
let table = document.getElementsByClassName("items-table")[0];
if (table) {
    if (document.documentElement.offsetWidth <= 820 || 
        (main.offsetWidth / main.offsetHeight < 1.3 && 
        document.getElementsByTagName("main")[0].querySelectorAll("td").length < 4)) {
        for (let img of table.querySelectorAll("td > *")) {
            if (img.tagName == "FIGURE" || img.querySelector("figure")) {
                img.style.width = "100%";
                img.style.overflow = "hidden";
                img.style.marginBottom = "20px";
            } else {
                img.classList.add("small-screen-img");
            }
            main.append(img);
            let imageCont = img.querySelector(".image-cont");
            if (imageCont && imageCont.parentElement.nodeName == "FIGURE") {
                imageCont.style.maxWidth = "70%";
                addEventListener("load", () => 
                imageCont.style.marginRight = imageCont.style.marginLeft = 
                (imageCont.parentElement.clientWidth - imageCont.offsetWidth) / 2 + "px");
            }
        }
        document.getElementsByTagName("table")[0].remove();
    } else {
        for (let tr of document.getElementsByTagName("tr")) {
            let headers = 0;
            for (let td of tr.querySelectorAll("td")) {
                if (td.querySelector("h3")) {
                    headers++;
                }
            }
            let maxHeaderHeight = 0;
            if (headers == 3) {
                for (let td of tr.querySelectorAll("td")) {
                    if (td.querySelector("h3").offsetHeight > maxHeaderHeight) {
                        maxHeaderHeight = td.querySelector("h3").offsetHeight;
                    }
                }
                for (let h3 of tr.querySelectorAll("td h3")) {
                    h3.style.height = maxHeaderHeight + "px";
                }
            }
        }    
    }
}
//position and resize images in their containers
for (let smallImg of main.querySelectorAll(".small-screen-img:nth-child(even)")) {
    let title1, title2;
    if (title1 = smallImg.querySelector("h3")) {
        if (smallImg.nextElementSibling) {
            if (title2 = smallImg.nextElementSibling.querySelector("h3")) {
                title1.style.height = title2.style.height = 
                Math.max(title1.offsetHeight, title2.offsetHeight) + "px";
            }
        }
    }
}
addEventListener("load", function () {
    for (let picture of main.querySelectorAll(".image-cont img")) {
        if (picture.parentElement.clientWidth / picture.offsetWidth <=
            picture.parentElement.clientHeight / picture.offsetHeight) {
            picture.style.width = "100%";
            picture.style.height = "auto";
            picture.style.maxWidth = "none";
            picture.style.maxHeight = "100%";
        } else {
            picture.style.height = "100%";
            picture.style.width = "auto";
            picture.style.maxHeight = "none";
            picture.style.maxWidth = "100%";
        }
    }
});