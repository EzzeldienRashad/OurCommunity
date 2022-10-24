gameStarted = 0;
document.getElementById("play").addEventListener("click", function play() {
gameStarted = 1;
document.getElementById("play").style.display = "none";
if (musicPlaying) {
    music.play();
}
//pollyfills
window.requestAnimationFrame = window.requestAnimationFrame
    || window.mozRequestAnimationFrame
    || window.webkitRequestAnimationFrame
    || window.msRequestAnimationFrame
    || function(f){return setTimeout(f, 1000/60)}
 
window.cancelAnimationFrame = window.cancelAnimationFrame
    || window.mozCancelAnimationFrame
    || function(requestID){clearTimeout(requestID)}

//fixed values
let minTimeBetweenCreations, maxTimeBetweenCreations, maxWallHeight, minWallHeight, wallsSpeed, ballTransitionDuration, wallsPerLevel;
minTimeBetweenCreations = 2300;
maxTimeBetweenCreations = 3000;
minJumpHeight = 1.1;
maxJumpHeight = 1.5;
wallsPerLevel = 10;
if (document.body.clientWidth <= 900) {
    ballTransitionDuration = 2000;
    maxWallHeight = 100;
    minWallHeight = 25;
    wallsSpeed = 2;
} else {
    ballTransitionDuration = 2400;
    maxWallHeight = 200;
    minWallHeight = 50;
    wallsSpeed = 3;
}
let hearts = 3;
let levelsColors = ["green", "cyan", "deepskyblue", "dodgerblue", "royalblue", "blue", "mediumslateblue", "purple", "red"];
let frame = document.getElementsByClassName("frame")[0];
let backgrounds = document.querySelectorAll(".frame-cont img");
//changable values
let lost = false;
let score = 0;
let level = 1;
let wallColor = "green";
let wallsTimeout;
//ball
let ball = document.createElement("div");
ball.className = "ball";
ball.style.transitionDuration = ballTransitionDuration / 3000 + "s";
frame.append(ball);
//level
let levelDiv = document.createElement("div");
levelDiv.classList.add("level-div");
levelDiv.append(document.createTextNode("level: "));
let levelSpan = document.createElement("span");
levelSpan.append(document.createTextNode("1"));
levelDiv.append(levelSpan);
frame.append(levelDiv);
//score
let scoreDiv = document.createElement("div");
scoreDiv.classList.add("score-div");
scoreDiv.append(document.createTextNode("points: "));
let scoreSpan = document.createElement("span");
scoreSpan.append(document.createTextNode("0"));
scoreDiv.append(scoreSpan);
frame.append(scoreDiv);
//prepare for the game start
backgrounds[backgrounds.length - 1].style.right = -backgrounds[backgrounds.length - 1].offsetWidth + 5 + "px";
//start game
displayHearts();
createWalls();
document.addEventListener("visibilitychange", function () {
    if (document.hidden) {
        stop()
    } else if (!lost) {
        continuePlaying();
    }
});
let moveWallsAF = requestAnimationFrame(moveWalls);
setTimeout(() => frame.addEventListener("click", moveBall), 0);

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

function makeWall() {
    let wall = document.createElement("div");
    wall.className = "wall";
    wall.style.height = minWallHeight + Math.random() * (maxWallHeight - minWallHeight) + "px";
    wall.style.backgroundColor = wallColor;
    frame.append(wall);
    wallsTimeout = setTimeout(() => makeWall(), Math.random() * (maxTimeBetweenCreations - minTimeBetweenCreations) + minTimeBetweenCreations);
}
function createWalls() {
    wallsTimeout = setTimeout(makeWall, Math.random() * (maxTimeBetweenCreations - minTimeBetweenCreations) + minTimeBetweenCreations);
}

function moveWalls() {
    if (lost) return;
    for (let wall of document.getElementsByClassName("wall")) {
        wall.style.right = frame.clientWidth - (wall.offsetLeft + wall.offsetWidth) + wallsSpeed + "px";
        if (wall.offsetLeft + wall.offsetWidth < 0) {
            wall.remove();
            score++;
            document.querySelector(".score-div span").innerHTML = score;
            if (!(score % wallsPerLevel)) {
                ratio = wallsSpeed / (wallsSpeed + 1);
                wallsSpeed++;
                ballTransitionDuration *= 0.5 + ratio / 2;
                minTimeBetweenCreations *= ratio * 1.1;
                maxTimeBetweenCreations *= ratio * 1.1;
                ball.style.transitionDuration = ballTransitionDuration / 3000 + "s";
                level++;
                document.querySelector(".level-div span").innerHTML = level;
                if (maxWallHeight * maxJumpHeight < frame.clientHeight) {
                    maxWallHeight *= 1.1;
                    minWallHeight *= 1.1;
                }
                if (level <= levelsColors.length) {
                    wallColor = levelsColors[level - 1];
                }
            }
        }
    }
    //lose on collision
    let wall1 = document.getElementsByClassName("wall")[0];
    if (wall1) {
        if (wall1.offsetLeft <= ball.offsetLeft + ball.offsetWidth && 
            wall1.offsetTop < ball.offsetTop + ball.offsetHeight && 
            wall1.offsetLeft + wall1.offsetWidth > ball.offsetLeft) {
            lose();
        } else {
            moveWallsAF = requestAnimationFrame(moveWalls);
        }
    } else {
        moveWallsAF = requestAnimationFrame(moveWalls);
    }
    //move background
    for (let i = 0; i < backgrounds.length; i++) {
        backgrounds[i].style.right = frame.clientWidth - (backgrounds[i].offsetLeft + backgrounds[i].offsetWidth) + wallsSpeed + "px";
        if (parseInt(backgrounds[i].style.right) >= frame.clientWidth) {
            backgrounds[i].style.right = parseInt(backgrounds[Number(!i)].style.right) - backgrounds[Number(i)].offsetWidth + wallsSpeed + 5 + "px";
        }
    }
}

function moveBall(event) {
    if (lost || event.target.classList.contains("music")) return;
    frame.removeEventListener("click", moveBall);
    ball.style.transitionTimingFunction = "ease-out";
    ball.style.bottom = maxWallHeight * (Math.random() * (maxJumpHeight - minJumpHeight) + minJumpHeight) + "px";
    if (musicPlaying) bounce.play();
    setTimeout(function () {
        if (lost) return;
        ball.style.transitionTimingFunction = "ease-in";
        ball.style.bottom = "0";
        setTimeout(() => frame.addEventListener("click", moveBall), ballTransitionDuration / 3);
    }, ballTransitionDuration / 3);
}

function stop() {
    music.pause();
    cancelAnimationFrame(moveWallsAF);
    clearTimeout(wallsTimeout);
    frame.removeEventListener("click", moveBall);
    ball.style.bottom = frame.clientHeight - (ball.offsetTop + ball.offsetHeight) + "px";
}

function continuePlaying() {
    if (musicPlaying) music.play();
    moveWallsAF = requestAnimationFrame(moveWalls);
    createWalls();
    frame.addEventListener("click", moveBall);
    ball.style.bottom = "0";
}

function lose() {
    if (musicPlaying) loseSound.play();
    stop();
    lost = true;
    setTimeout(function () {
        if (hearts) {
            hearts--;
            displayHearts();
            lost = false;
            for (let i = 0; i < document.getElementsByClassName("wall").length; i++) {
                document.getElementsByClassName("wall")[0].remove();
                i--;
            }
            ball.style.transitionDuration = "0s";
            continuePlaying()
            setTimeout(() => ball.style.transitionDuration = ballTransitionDuration / 3000 + "s", 0);
        } else {
            document.getElementById("replay").querySelector("button span").innerHTML = score;
            document.getElementById("replay").style.display = "block";
            music.muted = true;
        }
    }, 1000);
}

//replay
document.querySelector("#replay button").addEventListener("click", function () {
    location.reload();
});

});
//add music
musicPlaying = false;
let music = document.createElement("audio");
music.setAttribute("src", "../../../music/jumpball.mp3");
music.setAttribute("autoplay", true);
music.setAttribute("loop", true);
music.pause();
let speaker = document.getElementsByClassName("music")[0];
if (getCookie("music") == "on") {
    speaker.classList.remove("fa-volume-xmark");
    speaker.classList.add("fa-volume-high");
    musicPlaying = true;
}
speaker.addEventListener("click", function () {
    if (speaker.classList.contains("fa-volume-high")) {
        speaker.classList.remove("fa-volume-high");
        speaker.classList.add("fa-volume-xmark");
        musicPlaying = false;
        document.cookie = "music=off; max-age=" + 60 * 60 * 24 * 30;
    } else {
        speaker.classList.remove("fa-volume-xmark");
        speaker.classList.add("fa-volume-high");
        musicPlaying = true;
        document.cookie = "music=on; max-age=" + 60 * 60 * 24 * 30;
    }
    if (musicPlaying && gameStarted) {
        music.play();
    } else if (!musicPlaying && gameStarted) {
        music.pause();
        music.currentTime = 0;
    }
});
let bounce = document.createElement("audio");
bounce.setAttribute("src", "../../../music/bounce.mp3");
let loseSound = document.createElement("audio");
loseSound.setAttribute("src", "../../../music/lose.mp3");

//main functions
function getCookie(name) {
    let cookies = document.cookie.split(";");
    for (let cookie of cookies) {
        let cookieArr = cookie.split("=");
        if (name == cookieArr[0].trim()) {
            return cookieArr[1].trim();
        }
    }
    return null;
}
