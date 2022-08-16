// get and update comments
let commentsCont = document.getElementsByClassName("comments-cont")[0];
let commentsCount = 10;
let scrolled = false;
let scroll = scrollY;
let addingC2c = 0;
function loadComments() {
    fetch("arrays/comments.php")
        .then(response => response.json())
        .then(function (comments) {
            scroll = scrollY;
            commentsCont.innerHTML = "";
            for (let i = 1; i <= (comments.length > commentsCount ? commentsCount : comments.length); i++) {
                let name = comments[i - 1]["name"];
                let hasComment = name == document.querySelector(".hello span").textContent;
                let comment = comments[i - 1]["body"];
                let date = new Date(comments[i - 1]["date"].replace(/:(?=.*?\s)/g, "-").replace(/\s/, "T"));
                let id = comments[i - 1]["id"];
                let lovers = JSON.parse(comments[i - 1]["lovers"]);
                let loveCount = lovers.length;
                let c2cs = JSON.parse(comments[i - 1]["comments"].replace(/\r/g, "\\r").replace(/\n/g, "\\n"));
                let commentCont = document.createElement("div");
                commentCont.className = "comment";
                let commenter = document.createElement("h2");
                commenter.textContent = name;
                commentCont.append(commenter);
                let curve = document.createElement("span");
                curve.className = "curve";
                if (hasComment) {
                    curve.insertAdjacentHTML("beforeend", "<i class='fa-solid fa-circle-xmark fa-lg'></i>");
                    curve.querySelector("i").addEventListener("click", function () {
                        location.href = "?deleteCommentId=" + id + "&scroll=" + scrollY;
                    });
                }
                commentCont.append(curve);
                let commentInfo = document.createElement("div");
                commentInfo.className = "comment-info";
                if (loveCount) {
                    let love = document.createElement("span");
                    love.className = "love-count";
                    love.innerHTML = "<i class='fa-solid fa-heart'></i>";
                    commentInfo.append(love);
                    love.insertAdjacentHTML("afterend", "<br />");
                    love.insertAdjacentHTML("beforebegin", loveCount);
                }
                let milliseconds = Date.now() - date.getTime();
                let minutes = Math.round(milliseconds / 60_000);
                let hours = Math.round(minutes / 60);
                let days = Math.round(minutes / 1440);
                let months = Math.round(days / 30);
                let years = Math.round(days / 365);
                let commentDate = minutes < 1 ? "just now" : minutes < 60 ? "from " + minutes + " minutes" : 
                hours < 24 ? "from " + hours + " hours" : days < 30 ? "from " + days + " days" :
                months < 12 ? "from " + months + "months" : "from " + years + " years";
                let commentTime = document.createElement("span");
                commentTime.innerHTML = "<i class='fa-solid fa-clock'></i>" + commentDate;
                commentTime.className = "comment-time";
                commentInfo.append(commentTime);
                commentCont.append(commentInfo);
                let commentBody = document.createElement("div");
                commentBody.className = "comment-body";
                let commentArr = comment.replace(/\r/g, "").split("\n");
                for (let commentPart of commentArr) {
                    commentBody.appendChild(document.createTextNode(commentPart));
                    commentBody.appendChild(document.createElement("br"));
                }
                if (!hasComment) {
                    commentBody.insertAdjacentHTML("beforeend", "<i class='fa-solid fa-heart-circle-plus'></i>");
                    let heart = commentBody.querySelector("i");
                    heart.style.color = lovers.includes(document.querySelector(".hello span").textContent) ? "red" : "grey";
                    heart.addEventListener("click", function () {
                        location.href = "?loveCommentId=" + id + "&scroll=" + scrollY;
                    });
                }
                commentCont.append(commentBody);
                let c2cCont = document.createElement("div");
                c2cCont.className = "c2c-cont";
                for (let c2c of c2cs) {
                    let c2cDiv = document.createElement("div");
                    let c2cName = c2c.split(":")[0] + ":";
                    let c2cNameSpan = document.createElement("span");
                    c2cNameSpan.className = "c2c-name";
                    c2cNameSpan.textContent = c2cName;
                    c2cDiv.append(c2cNameSpan);
                    let c2cArray = c2c.split(c2cName)[1].replace(/\r/g, "").split("\n");
                    let c2cParagraph = document.createElement("p");
                    for (let c2cPart of c2cArray) {
                        c2cParagraph.appendChild(document.createTextNode(c2cPart));
                        c2cParagraph.appendChild(document.createElement("br"));
                    }
                    c2cDiv.append(c2cParagraph);
                    c2cCont.append(c2cDiv);
                    c2cCont.append(document.createElement("hr"));
                }
                let addC2cForm = document.createElement("form");
                addC2cForm.className = "add-c2c-div";
                addC2cForm.setAttribute("method", "post");
                let addC2cTextarea = document.createElement("textarea");
                addC2cTextarea.className = "add-c2c-textarea";
                addC2cTextarea.setAttribute("name", "c2cContent");
                addC2cForm.append(addC2cTextarea);
                let addC2cBtn = document.createElement("input");
                addC2cBtn.className = "add-c2c-btn";
                addC2cBtn.setAttribute("type", "submit");
                addC2cBtn.setAttribute("name", "c2cSubmit");
                addC2cBtn.setAttribute("value", "+add comment");
                addC2cForm.append(addC2cBtn);
                c2cCont.append(addC2cForm);
                commentCont.append(c2cCont);
                let addC2c = document.createElement("button");
                addC2c.className = "add-c2c";
                addC2c.textContent = "+ add comment";
                addC2c.addEventListener("click", function () {
                    if (!addC2cForm.classList.contains("add-c2c-div-show")) {
                        addC2cForm.classList.add("add-c2c-div-show");
                        addC2cTextarea.focus();
                        if (commentInterval) {
                            commentInterval =  clearInterval(commentInterval);
                        }
                        addingC2c++;
                    } else {
                        addC2cForm.classList.remove("add-c2c-div-show");
                        addingC2c--;
                        if (!addingC2c) {
                            setTimeout(() => loadComments(), 250);
                            commentInterval = setInterval(loadComments, 3000);
                        }
                    }
                });
                commentCont.append(addC2c);
                commentsCont.append(commentCont);
                curve.style.height = commenter.offsetHeight + "px";
                addC2cForm.setAttribute("action", "?c2cId=" + id + "&scroll=" + (addC2cForm.getBoundingClientRect().top - commentCont.offsetHeight));
            }
            scrollTo(0, scroll);
            if (location.href.includes("scroll=") && !scrolled) {
                scrollTo(0, Number(location.href.split("scroll=")[1]));
                scrolled = true;
            }
        });
}
loadComments();
let commentInterval = setInterval(loadComments, 3000);
// showing comments area
document.getElementsByClassName("add-comment")[0].addEventListener("click", function () {
    let commentArea = document.getElementsByClassName("new-comment")[0];
    commentArea.classList.toggle("display-comment-area");
    if (commentArea.getAttribute("aria-hidden") == "true") {
        commentArea.querySelector("textarea").focus();
        commentArea.setAttribute("aria-hidden", "false");
    } else {
        commentArea.setAttribute("aria-hidden", "true");
    }
})
//load more comments on button click
document.getElementsByClassName("more-comments")[0].addEventListener("click", function () {
    commentsCount += 10;
    if (commentsCount >= 50) {
        document.getElementsByClassName("more-comments")[0].remove();
    }
    loadComments();
});