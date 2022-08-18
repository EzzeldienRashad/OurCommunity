window.requestAnimationFrame = window.requestAnimationFrame
    || window.mozRequestAnimationFrame
    || window.webkitRequestAnimationFrame
    || window.msRequestAnimationFrame
    || function(f){return setTimeout(f, 1000/60)}
 
window.cancelAnimationFrame = window.cancelAnimationFrame
    || window.mozCancelAnimationFrame
    || function(requestID){clearTimeout(requestID)}

let ball = document.createElement("div");
let frame = document.getElementsByClassName("frame")[0];
let timeBetweenCreations = 2000;
let maxWallHeight = 200;
let minWallHeight = 50;
let wallsSpeed = 3;
let hearts = 3;
let lost = false;
ball.className = "ball";
frame.append(ball);
ball.style.transitionDuration = timeBetweenCreations / 3000 + "s";
displayHearts();
createWall();
let wallsInterval = setInterval(createWall, timeBetweenCreations);
document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        clearInterval(wallsInterval);
    } else {
        wallsInterval = setInterval(createWall, timeBetweenCreations);
    }
});
let moveWallsAF = requestAnimationFrame(moveWalls);
frame.addEventListener("click", moveBall);

//functions
function displayHearts() {
    for (let heart of frame.querySelectorAll(".heart")) {
        heart.remove();
    }
    for (i = 0; i < hearts; i++) {
        let heart = document.createElement("i");
        heart.className = "heart fa-lg fa-solid fa-heart";
        frame.append(heart);
    }
}

function createWall() {
    let wall = document.createElement("div");
    wall.className = "wall";
    wall.style.height = minWallHeight + Math.random() * (maxWallHeight - minWallHeight) + "px";
    frame.append(wall);
}

function moveWalls() {
    if (lost) return;
    for (let wall of document.getElementsByClassName("wall")) {
        wall.style.right = frame.clientWidth - (wall.offsetLeft + wall.offsetWidth) + wallsSpeed + "px";
        if (wall.offsetLeft + wall.offsetWidth < 0) {
            wall.remove();
        }
    }
    //lose on collision
    let wall1 = document.getElementsByClassName("wall")[0];
    if (wall1) {
        if (wall1.offsetLeft <= ball.offsetLeft + ball.offsetWidth && 
            wall1.offsetTop < ball.offsetTop + ball.offsetHeight && 
            wall1.offsetLeft + wall1.offsetWidth > ball.offsetLeft) {
            cancelAnimationFrame(moveWallsAF);
            clearInterval(wallsInterval);
            frame.removeEventListener("click", moveBall);
            lost = true;
            ball.style.bottom = frame.clientHeight - (ball.offsetTop + ball.offsetHeight) + "px";
            setTimeout(lose, 1000);
        } else {
            moveWallsAF = requestAnimationFrame(moveWalls);
        }
    } else {
        moveWallsAF = requestAnimationFrame(moveWalls);
    }
}

function moveBall() {
    if (lost) return;
    frame.removeEventListener("click", moveBall);
    ball.style.transitionTimingFunction = "ease-out";
    ball.style.bottom = maxWallHeight + 100 + "px";
    setTimeout(function () {
        if (lost) return;
        ball.style.transitionTimingFunction = "ease-in";
        ball.style.bottom = "0";
        setTimeout(() => frame.addEventListener("click", moveBall), timeBetweenCreations / 3);
    }, timeBetweenCreations / 3);
}

function lose() {
    if (hearts) {
        hearts--;
        displayHearts();
        wallsInterval = setInterval(createWall, timeBetweenCreations);
        frame.addEventListener("click", moveBall);
        lost = false;
        for (let i = 0; i < document.getElementsByClassName("wall").length; i++) {
            document.getElementsByClassName("wall")[0].remove();
            i--;
        }
        ball.style.transitionDuration = "0s";
        ball.style.bottom = "0";
        setTimeout(() => ball.style.transitionDuration = timeBetweenCreations / 3000 + "s", 0);
        moveWallsAF = requestAnimationFrame(moveWalls);
    } else {
        document.getElementById("replay").style.display = "block";
    }
}

function reload() {
    location.reload();
}